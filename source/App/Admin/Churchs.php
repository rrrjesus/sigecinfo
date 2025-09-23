<?php

namespace Source\App\Admin;

use Source\Models\Company\Church;
use Source\Support\Upload;
use Source\Support\Thumb;

/**
 * Class Churchs
 * @package Source\App\Admin
 */
class Churchs extends Admin
{
    /**
     * Churchs constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista igrejas ativas
     */
    public function churchs(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Igrejas - " . CONF_SITE_NAME, CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        $churchs = (new Church())->find("status = :s", "s=actived")->order("church_name ASC")->fetch(true);
        
        echo $this->view->render("widgets/company/churchs/list", [
            "head" => $head,
            "churchs" => $churchs,
            "registers" => (object)["disabled" => (new Church())->find("status = :s", "s=disabled")->count()]
        ]);
    }

    /**
     * Lista igrejas desativadas
     */
    public function disabledChurchs(): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        $head = $this->seo->render("Igrejas Desativadas - " . CONF_SITE_NAME, CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        $churchs = (new Church())->find("status = :s", "s=disabled")->order("church_name ASC")->fetch(true);

        echo $this->view->render("widgets/company/churchs/disabledList", [
            "head" => $head,
            "churchs" => $churchs
        ]);
    }

    /**
     * @param array|null $data
     */
    public function create(?array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data = array_map('trim', $data);

            $churchCreate = new Church();
            $churchCreate->church_name = $data["church_name"];
            $churchCreate->country_id = $data["country_id"];
            $churchCreate->code_id = $data["code_id"];
            $churchCreate->phone = $data["phone"];
            $churchCreate->zip_code = $data["zip_code"];
            $churchCreate->address = $data["address"];
            $churchCreate->address_number = $data["address_number"];
            $churchCreate->city = $data["city"];
            $churchCreate->state = $data["state"];
            $churchCreate->observations = $data["observations"];
            $churchCreate->login_created = $this->user->id;

            if (!empty($_FILES["photo"])) {
                $upload = new Upload();
                $image = $upload->image($_FILES["photo"], $churchCreate->church_name, 600);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $churchCreate->photo = $image;
            }

             if($data["church_name"] == "" || $data["country_id"] == "" || $data["code_id"] == "" || $data["zip_code"] == "" || $data["address"] == "" || $data["address_number"] == "" || $data["city"] == "" || $data["state"] == ""){
                $json['message'] = $this->message->info("Informe a igreja, país, código, cep, endereço, número, cidade e estado para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$churchCreate->save()) {
                $json["message"] = $churchCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja cadastrada com sucesso!")->flash();
            $json["redirect"] = url("/painel/igrejas");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Cadastrar Igreja - " . CONF_SITE_NAME, CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        echo $this->view->render("widgets/company/churchs/church", [
            "head" => $head,
            "church" => null
        ]);
    }

    /**
     * @param array $data
     */
    public function edit(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $churchId = filter_var($data["church_id"], FILTER_VALIDATE_INT);
        $churchUpdate = (new Church())->findById($churchId);

        if (!$churchUpdate) {
            $this->message->error("Você tentou editar uma igreja que não existe.")->flash();
            redirect("/painel/igrejas");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data = array_map('trim', $data);
            
            $churchUpdate->church_name = $data["church_name"];
            $churchUpdate->country_id = $data["country_id"];
            $churchUpdate->code_id = $data["code_id"];
            $churchUpdate->phone = $data["phone"];
            $churchUpdate->zip_code = $data["zip_code"];
            $churchUpdate->address = $data["address"];
            $churchUpdate->address_number = $data["address_number"];
            $churchUpdate->city = $data["city"];
            $churchUpdate->state = $data["state"];
            $churchUpdate->observations = $data["observations"];
            $churchUpdate->login_updated = $this->user->id;
            
            if (!empty($_FILES["photo"])) {

                $upload = new Upload();

                if ($churchUpdate->photo) {
                    (new Thumb())->flush("storage/{$churchUpdate->photo}");
                    $upload->remove("storage/{$churchUpdate->photo}");
                }
                
                $image = $upload->image($_FILES["photo"], "{$churchUpdate->church_name} " . time(), 600);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $churchUpdate->photo = $image;
            }

            if($data["church_name"] == "" || $data["country_id"] == "" || $data["code_id"] == "" || $data["zip_code"] == "" || $data["address"] == "" || $data["address_number"] == "" || $data["city"] == "" || $data["state"] == ""){
                $json['message'] = $this->message->info("Informe a igreja, país, código, cep, endereço, número, cidade e estado para editar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$churchUpdate->save()) {
                $json["message"] = $churchUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Igreja atualizada com sucesso!")->flash();
            $json["redirect"] = url("/painel/igrejas/editar/{$churchUpdate->id}");
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render("Editar Igreja: {$churchUpdate->church_name}", CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        echo $this->view->render("widgets/company/churchs/church", [
            "head" => $head,
            "church" => $churchUpdate
        ]);
    }

    /**
     * @param array $data
     */
    public function delete(array $data): void
    {
        $this->authorize(['Administrador do Sistema']);
        $churchId = filter_var($data["church_id"], FILTER_VALIDATE_INT);
        $churchDelete = (new Church())->findById($churchId);

        if ($churchDelete) {
            if ($churchDelete->photo) {
                (new Thumb())->flush("storage/{$churchDelete->photo}");
                (new Upload())->remove("storage/{$churchDelete->photo}");
            }
            $churchDelete->destroy();
        }

        $this->message->success("A igreja foi excluída com sucesso. Redirecionando...");

        $json["message"] = $this->message->render(); // Usa render() para enviar a mensagem no JSON
        $json["redirect"] = url("/painel/igrejas"); // Envia a URL de redirect no JSON

        echo json_encode($json);
    }

    /**
     * @param array $data
     */
    public function toggleStatus(array $data): void
    {
        $this->authorize(['Editor Administrador', 'Administrador do Sistema']);
        $churchId = filter_var($data["church_id"], FILTER_VALIDATE_INT);
        $church = (new Church())->findById($churchId);

        if ($church) {
            $church->status = ($church->status == "actived" ? "disabled" : "actived");
            $church->login_updated = $this->user->id;
            $church->save();
        }

        if($church->status == "actived"):
            $this->message->success("A igreja {$church->church_name} foi ativada com sucesso !!!")->flash();
        else:
            $this->message->success("A igreja {$church->church_name} foi desativada com sucesso !!!")->flash();
        endif;
        
        redirect(url_back());
    }
}