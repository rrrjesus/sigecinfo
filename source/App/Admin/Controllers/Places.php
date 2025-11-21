<?php

namespace Source\App\Admin\Controllers;

use Source\Domain\Place\Models\Place;
use Source\Support\Upload;
use Source\Support\Thumb;
use Source\App\Admin\Admin;

/**
 * Class Places
 * @package Source\App\Admin
 */
class Places extends Admin
{
    /**
     * Places constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista locais ativas
     */
    public function places(): void
    {
        $this->authorize('places', 'view');

        $head = $this->seo->render("Locais - " . CONF_SITE_NAME, CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        $places = (new Place())->find("status = :s", "s=actived")->order("place_name ASC")->fetch(true);

        $breadcrumb = [
            ["title" => "Locais", "link" => url("/painel/locais")],
            ["title" => "Ativas"]
        ];
        
        echo $this->view->render("widgets/places/list", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "places" => $places,
            "registers" => (object)["disabled" => (new Place())->find("status = :s", "s=disabled")->count()]
        ]);
    }

    /**
     * Lista Locais desativadas
     */
    public function disabledPlaces(): void
    {
        $this->authorize('places', 'view');

        $head = $this->seo->render("Locais Desativados - " . CONF_SITE_NAME, CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        $places = (new Place())->find("status = :s", "s=disabled")->order("place_name ASC")->fetch(true);

        $breadcrumb = [
            ["title" => "Locais", "link" => url("/painel/locais/desativados")],
            ["title" => "Desativados"]
        ];

        echo $this->view->render("widgets/places/disabledList", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "places" => $places
        ]);
    }

    /**
     * @param array|null $data
     */
    public function create(?array $data): void
    {
        $this->authorize('places', 'create');

        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data = array_map('trim', $data);

            $placeCreate = new Place();
            $placeCreate->place_name = $data["place_name"];
            $placeCreate->country_id = $data["country_id"];
            $placeCreate->code_id = $data["code_id"];
            $placeCreate->phone = $data["phone"];
            $placeCreate->zip_code = $data["zip_code"];
            $placeCreate->address = $data["address"];
            $placeCreate->address_number = $data["address_number"];
            $placeCreate->city = $data["city"];
            $placeCreate->state = $data["state"];
            $placeCreate->observations = $data["observations"];
            $placeCreate->login_created = $this->user->id;

            if (!empty($_FILES["photo"])) {
                $upload = new Upload();
                $image = $upload->image($_FILES["photo"], $placeCreate->place_name, 600);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $placeCreate->photo = $image;
            }

             if($data["place_name"] == "" || $data["country_id"] == "" || $data["code_id"] == "" || $data["zip_code"] == "" || $data["address"] == "" || $data["address_number"] == "" || $data["city"] == "" || $data["state"] == ""){
                $json['message'] = $this->message->info("Informe o local, país, código, cep, endereço, número, cidade e estado para criar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$placeCreate->save()) {
                $json["message"] = $placeCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Local {$placeCreate->place_name} cadastrada com sucesso!")->flash();
            $json["redirect"] = url("/painel/locais/cadastrar");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Locais", "link" => url("/painel/locais/cadastrar")],
            ["title" => "Cadastrar"]
        ];

        $head = $this->seo->render("Cadastrar Local - " . CONF_SITE_NAME, CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        echo $this->view->render("widgets/places/place", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "place" => null
        ]);
    }

    /**
     * @param array $data
     */
    public function edit(array $data): void
    {
        $this->authorize('places', 'edit');
        $placeId = filter_var($data["place_id"], FILTER_VALIDATE_INT);
        $placeUpdate = (new Place())->findById($placeId);

        if (!$placeUpdate) {
            $this->message->error("Você tentou editar um local que não existe.")->flash();
            redirect("/painel/locais");
        }

        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data = array_map('trim', $data);
            
            $placeUpdate->place_name = $data["place_name"];
            $placeUpdate->country_id = $data["country_id"];
            $placeUpdate->code_id = $data["code_id"];
            $placeUpdate->phone = $data["phone"];
            $placeUpdate->zip_code = $data["zip_code"];
            $placeUpdate->address = $data["address"];
            $placeUpdate->address_number = $data["address_number"];
            $placeUpdate->city = $data["city"];
            $placeUpdate->state = $data["state"];
            $placeUpdate->observations = $data["observations"];
            $placeUpdate->login_updated = $this->user->id;
            
            if (!empty($_FILES["photo"])) {

                $upload = new Upload();

                if ($placeUpdate->photo) {
                    (new Thumb())->flush("storage/{$placeUpdate->photo}");
                    $upload->remove("storage/{$placeUpdate->photo}");
                }
                
                $image = $upload->image($_FILES["photo"], "{$placeUpdate->place_name} " . time(), 600);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $placeUpdate->photo = $image;
            }

            if($data["place_name"] == "" || $data["country_id"] == "" || $data["code_id"] == "" || $data["zip_code"] == "" || $data["address"] == "" || $data["address_number"] == "" || $data["city"] == "" || $data["state"] == ""){
                $json['message'] = $this->message->info("Informe o local, país, código, cep, endereço, número, cidade e estado para editar o registro !")->icon()->render();
                echo json_encode($json);
                return;
            }

            if (!$placeUpdate->save()) {
                $json["message"] = $placeUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Local {$placeUpdate->place_name} atualizada com sucesso!")->flash();
            $json["redirect"] = url("/painel/locais/editar/{$placeUpdate->id}");
            echo json_encode($json);
            return;
        }

        $breadcrumb = [
            ["title" => "Locais", "link" => url("/painel/locais/editar/{$placeUpdate->id}")],
            ["title" => "Editar"]
        ];

        $head = $this->seo->render("Editar Local: {$placeUpdate->place_name}", CONF_SITE_DESC, url(), theme("/assets/images/favicon.ico"), false);
        echo $this->view->render("widgets/places/place", [
            "head" => $head,
            "breadcrumb" => $breadcrumb,
            "place" => $placeUpdate
        ]);
    }

    /**
     * @param array $data
     */
    public function delete(array $data): void
    {
        $this->authorize('places', 'delete');

        $placeId = filter_var($data["place_id"], FILTER_VALIDATE_INT);
        $placeDelete = (new Place())->findById($placeId);

        if ($placeDelete) {
            if ($placeDelete->photo) {
                (new Thumb())->flush("storage/{$placeDelete->photo}");
                (new Upload())->remove("storage/{$placeDelete->photo}");
            }
            $placeDelete->destroy();
        }

        $this->message->success("O local {$placeDelete->place_name} foi excluída com sucesso.")->flash();
        redirect(url_back());
    }

    /**
     * @param array $data
     */
    public function toggleStatus(array $data): void
    {
        $this->authorize('places', 'edit');
        $placeId = filter_var($data["place_id"], FILTER_VALIDATE_INT);
        $place = (new Place())->findById($placeId);

        if ($place) {
            $place->status = ($place->status == "actived" ? "disabled" : "actived");
            $place->login_updated = $this->user->id;
            $place->save();
        }

        if($place->status == "actived"):
            $this->message->success("O local {$place->place_name} foi ativada com sucesso !!!")->flash();
        else:
            $this->message->success("O local {$place->place_name} foi desativada com sucesso !!!")->flash();
        endif;
        
        redirect(url_back());
    }
}