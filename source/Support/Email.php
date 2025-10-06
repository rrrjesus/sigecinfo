<?php

namespace Source\Support;

use SendGrid;
use SendGrid\Mail\Mail;
use Source\Core\Connect; // Necessário para a fila

/**
 * Class Email
 * Abstrai o serviço de envio de e-mail, usando SendGrid como provedor.
 * @package Source\Support
 */
class Email
{
    /** @var Mail */
    private $mail;

    /** @var Message */
    private $message;

    /** @var \stdClass */
    private $data;

    /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->mail = new Mail();
        $this->message = new Message();
        $this->data = new \stdClass();
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient_email
     * @param string $recipient_name
     * @return Email
     */
    public function bootstrap(string $subject, string $body, string $recipient_email, string $recipient_name): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_email = $recipient_email;
        $this->data->recipient_name = $recipient_name;
        return $this;
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @return Email
     */
    public function attach(string $filePath, string $fileName): Email
    {
        // A lógica de anexos pode ser implementada aqui se necessário
        return $this;
    }

    /**
     * @param string $from_email
     * @param string $from_name
     * @return bool
     */
    public function send(string $from_email = CONF_MAIL_SENDER['address'], string $from_name = CONF_MAIL_SENDER["name"]): bool
    {
        if (empty($this->data)) {
            $this->message->error("Erro ao enviar, por favor verifique os dados");
            return false;
        }

        if (!is_email($this->data->recipient_email)) {
            $this->message->warning("O e-mail de destinatário não é válido");
            return false;
        }

        if (!is_email($from_email)) {
            $this->message->warning("O e-mail de remetente não é válido");
            return false;
        }

        try {
            $this->mail->setFrom($from_email, $from_name);
            $this->mail->setSubject($this->data->subject);
            $this->mail->addTo($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->addContent("text/html", $this->data->body);

            $sendgrid = new SendGrid(CONF_SENDGRID_API_KEY);
            $response = $sendgrid->send($this->mail);

            if ($response->statusCode() >= 200 && $response->statusCode() <= 299) {
                return true;
            } else {
                // Em um ambiente de produção, seria ideal registar este erro num log.
                $this->message->error("Ocorreu um erro ao enviar o e-mail: " . $response->body());
                return false;
            }
        } catch (\Exception $exception) {
            $this->message->error($exception->getMessage());
            return false;
        }
    }

    /**
     * Adiciona um e-mail à fila do banco de dados para ser enviado posteriormente.
     * @param string $from_email
     * @param string $from_name
     * @return bool
     */
    public function queue(string $from_email = CONF_MAIL_SENDER['address'], string $from_name = CONF_MAIL_SENDER["name"]): bool
    {
        // ESTE MÉTODO NÃO PRECISA DE ALTERAÇÕES.
        // A lógica de guardar na base de dados é independente do provedor de envio.
        try {
            $stmt = Connect::getInstance()->prepare(
                "INSERT INTO mail_queue (subject, body, from_email, from_name, recipient_email, recipient_name)
                 VALUES (:subject, :body, :from_email, :from_name, :recipient_email, :recipient_name)"
            );

            $stmt->bindValue(":subject", $this->data->subject, \PDO::PARAM_STR);
            $stmt->bindValue(":body", $this->data->body, \PDO::PARAM_STR);
            $stmt->bindValue(":from_email", $from_email, \PDO::PARAM_STR);
            $stmt->bindValue(":from_name", $from_name, \PDO::PARAM_STR);
            $stmt->bindValue(":recipient_email", $this->data->recipient_email, \PDO::PARAM_STR);
            $stmt->bindValue(":recipient_name", $this->data->recipient_name, \PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->message->error($exception->getMessage());
            return false;
        }
    }

    /**
     * Envia os e-mails que estão na fila.
     * @param int $perSecond Limite de envios por segundo para evitar bloqueios.
     */
    public function sendQueue(int $perSecond = 5): void
    {
        // ESTE MÉTODO TAMBÉM NÃO PRECISA DE ALTERAÇÕES.
        // Ele busca os e-mails e usa o método ->send(), que já está refatorado para SendGrid.
        $stmt = Connect::getInstance()->query("SELECT * FROM mail_queue WHERE sent_at IS NULL");
        if ($stmt->rowCount()) {
            foreach ($stmt->fetchAll() as $send) {
                $email = $this->bootstrap(
                    $send->subject,
                    $send->body,
                    $send->recipient_email,
                    $send->recipient_name
                );

                if ($email->send($send->from_email, $send->from_name)) {
                    usleep(1000000 / $perSecond);
                    Connect::getInstance()->exec("UPDATE mail_queue SET sent_at = NOW() WHERE id = {$send->id}");
                }
            }
        }
    }

    /**
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }
}