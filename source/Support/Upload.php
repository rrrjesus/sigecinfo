<?php

namespace Source\Support;

use CoffeeCode\Uploader\File;
use CoffeeCode\Uploader\Image;
use CoffeeCode\Uploader\Media;

/**
 * FSPHP | Class Upload
 *
 * @author SIGECINFO Team <contato@sigecinfo.com.br>
 * @package Source\Support
 */
class Upload
{
    /** @var Message */
    private $message;

    /**
     * Upload constructor.
     */
    public function __construct()
    {
        $this->message = new Message();
    }

    /**
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }

    /**
     * @param array|string $image
     * @param string $name
     * @param int $width
     * @param string|null $dir
     * @param bool $pathByDate
     * @return string|null
     */
    public function image($image, string $name, int $width = CONF_IMAGE_SIZE, string $dir = null, bool $pathByDate = true): ?string
    {
        $dir = $dir ?? CONF_UPLOAD_IMAGE_DIR;
        $upload = new Image(CONF_UPLOAD_DIR, $dir, $pathByDate);

        if (is_string($image)) {
            if (!file_exists($image)) {
                $this->message->error("Arquivo de imagem não encontrado.");
                return null;
            }
            $fileInfo = pathinfo($image);
            $fileData = [
                'name' => $name . '.' . ($fileInfo['extension'] ?? 'png'),
                'type' => mime_content_type($image),
                'tmp_name' => $image,
                'error' => 0,
                'size' => filesize($image)
            ];
            $image = $fileData;
        }

        if (empty($image['type']) || !in_array($image['type'], $upload::isAllowed())) {
            $this->message->error("Você não selecionou uma imagem válida ou tipo de arquivo inválido.");
            return null;
        }

        try {
            return str_replace(CONF_UPLOAD_DIR . "/", "", $upload->upload($image, $name, $width, CONF_IMAGE_QUALITY));
        } catch (\Exception $e) {
            $this->message->error($e->getMessage());
            return null;
        }
    }

    /**
     * @param array $file
     * @param string $name
     * @return null|string
     * @throws \Exception
     */
    public function file(array $file, string $name): ?string
    {
        $upload = new File(CONF_UPLOAD_DIR, CONF_UPLOAD_FILE_DIR);
        if (empty($file['type']) || !in_array($file['type'], $upload::isAllowed())) {
            $this->message->error("Você não selecionou um arquivo válido");
            return null;
        }

        return str_replace(CONF_UPLOAD_DIR . "/", "", $upload->upload($file, $name));
    }

    /**
     * @param array $media
     * @param string $name
     * @return null|string
     * @throws \Exception
     */
    public function media(array $media, string $name): ?string
    {
        $upload = new Media(CONF_UPLOAD_DIR, CONF_UPLOAD_MEDIA_DIR);
        if (empty($media['type']) || !in_array($media['type'], $upload::isAllowed())) {
            $this->message->error("Você não selecionou uma mídia válida");
            return null;
        }

        return str_replace(CONF_UPLOAD_DIR . "/", "", $upload->upload($media, $name));
    }

    /**
     * @param string $filePath
     */
    public function remove(string $filePath): void
    {
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }
    }
}