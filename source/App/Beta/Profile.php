<?php

namespace Source\App\Beta;

use Source\Models\Company\User;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class Profile
 * @package Source\App\Beta
 */
class Profile extends Admin
{
    /**
     * Profile constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function profile(?array $data): void
    {
        if (!empty($data["update"])) {
            $user = (new User())->findById($this->user->id);
            $user->fixed_phone = preg_replace("/[^0-9]/", "", $data["fixed_phone"]);
            $user->cell_phone = preg_replace("/[^0-9]/", "", $data["cell_phone"]);

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();

                if ($this->user->photo()) {
                    (new Thumb())->flush("storage/{$this->user->photo}");
                    $upload->remove("storage/{$this->user->photo}");
                }

                if (!$user->photo = $upload->image($file, "{$user->user_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$this->user->user_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if (!empty($data["password"])) {
                if (empty($data["password_re"]) || $data["password"] != $data["password_re"]) {
                    $json["message"] = $this->message->warning("Para alterar sua senha, informe e repita a nova senha!")->icon()->render();
                    echo json_encode($json);
                    return;
                }

                $user->password = $data["password"];
            }

            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Pronto {$this->user->user_name}. Seus dados foram atualizados com sucesso !!!")->icon("emoji-grin me-1")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Meu perfil - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/favicon.ico"),
            false
        );

        echo $this->view->render("widgets/profile/profile", [
            "head" => $head,
            "user" => $this->user,
            "urls" => "perfil",
            "icon" => "person",
            "urls" => "perfil",
            "namepage" => "Usuários",
            "name" => "Perfil",
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) :
                theme("/assets/images/avatar.jpg", CONF_VIEW_APP))
        ]);
    }
}