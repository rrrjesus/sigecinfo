<?php

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */

/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param string $password
 * @return bool
 */
function is_passwd(string $password): bool
{
    return \Source\Boot\Password::isStrong($password);
}

/**
 * @param int $imei
 * @return int
 */
function is_imei(string $imei): string
{
    // Verifica se o número é um inteiro e se tem exatamente 15 dígitos
    if (is_numeric($imei) && strlen($imei) === 15 && intval($imei) == $imei) {
        return true;
    }

    return false;
}

/**
 * @param int $imei
 * @return int
 */
function is_chip(string $chip): string
{
    // Verifica se o número é um inteiro e se tem exatamente 15 dígitos
    if (is_numeric($chip) && strlen($chip) === 9 && intval($chip) == $chip) {
        return true;
    }

    return false;
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * Sanitiza um array de dados, aplicando trim e strip_tags a cada valor escalar.
 * Ignora valores que sejam arrays (como os de um select múltiplo).
 * @param array $data O array de dados a ser limpo.
 * @return array O array de dados limpo.
 */
function sanitize_array(array $data): array
{
    $sanitizedData = [];
    foreach ($data as $key => $value) {
        // Verifica se o valor é uma string ou um número antes de o limpar
        if (is_scalar($value)) {
            $sanitizedData[$key] = strip_tags(trim($value));
        } else {
            // Se for um array (ou outro tipo), mantém o valor original
            $sanitizedData[$key] = $value;
        }
    }
    return $sanitizedData;
}

/**
 * @param string $string
 * @return string
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(["-----", "----", "---", "--"], "-",
        str_replace(" ", "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
    return $slug;
}

/**
 * @param string $string
 * @return string
 */
function sem_acento(string $string): string
{
    $string = filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $com = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
    $sem = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U');
    $acento = str_replace($com, $sem, $string);

    return $acento;
}

/**
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    $studlyCase = str_replace(" ", "",
        mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE)
    );

    return $studlyCase;
}

/**
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * @param string $string
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
}

/**
 * @param string $text
 * @return string
 */
function str_textarea(string $text): string
{
    $text = filter_var($text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $arrayReplace = ["&#10;", "&#10;&#10;", "&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;", "&#10;&#10;&#10;&#10;&#10;"];
    return "<p>" . str_replace($arrayReplace, "</p><p>", $text) . "</p>";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(" ", $string);
    $numWords = count($arrWords);

    if ($numWords < $limit) {
        return $string;
    }

    $words = implode(" ", array_slice($arrWords, 0, $limit));
    return "{$words}{$pointer}";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), " "));
    return "{$chars}{$pointer}";
}

/**
 * @param string $price
 * @return string
 */
function str_price(?string $price): string
{
    return number_format((!empty($price) ? $price : 0), 2, ",", ".");
}

/**
 * @param string|null $search
 * @return string
 */
function str_search(?string $search): string
{
    if (!$search) {
        return "all";
    }

    $search = preg_replace("/[^a-z0-9A-Z\@\ ]/", "", $search);
    return (!empty($search) ? $search : "all");
}

/**
 * ###############
 * ###   URL   ###
 * ###############
 */

/**
 * @param string $path
 * @return string
 */

function url(string $path = null): string
{
    // Verifica se está rodando em ambiente web
    $isLocalhost = isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], "localhost") !== false;

    if ($isLocalhost) {
        if ($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}


/**
 * @return string
 */
function url_back(): string
{
    return ($_SERVER['HTTP_REFERER'] ?? url());
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}


/**
 * @return string
 */
function navbar_active($url): ?string
{
    if(!empty($_GET['route'])) {
        if(strip_tags($_GET['route']) == $url) {
            return 'active';
        }
    } else {
        if($url == '/')
            return 'active';
    }
    return true;
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */

/**
 * @return \Source\Domain\User\Models\User|null
 */
function user(): ?\Source\Domain\User\Models\User
{
    return \Source\Domain\Shared\Models\Auth::user();
}

/**
 * @return \Source\Core\Session
 */
function session(): \Source\Core\Session
{
    return new \Source\Core\Session();
}

/**
 * @param string|null $path
 * @param string $theme
 * @return string
 */
function theme(string $path = null, string $theme = \CONF_VIEW_THEME): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URL_TEST . "/themes/{$theme}";
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE . "/themes/{$theme}";
}


/**
 * @return string $date
 */

 function color_month(): string
 {
 
     $date = date("m");
 
     switch($date) {
        case "01":
            $date = "secondary";
            break;
        case "02":
            $date = "orange";
            break;
        case "03":
            $date = "smsub";
            break;
        case "04":
            $date = "success";
            break;
        case "05":
            $date = "warning";
            break;
        case "06":
            $date = "danger";
            break;
        case "07":
            $date = "success";
            break;
        case "08":
            $date = "golden";
            break;
        case "09":
            $date = "warning";
            break;
        case "10":
            $date = "pink";
            break;
        case "11":
            $date = "info";
            break;
        case "12":
            $date = "danger";
            break;
        default:
            $date = "smsub";
     }
 
     return $date;
 
 }
 
/**
 * @return string $slide
 */
 
 function slide_month(): string {
 
     $date = date("m");
 
     switch($date) {
        case "01":
            $slide = "/assets/images/slides_meses/janeiro.jpg";
            break;
        case "02":
            $slide = "/assets/images/slides_meses/fevereiro.jpg";
            break;
        case "03":
            $slide = "/assets/images/slides_meses/marco.jpg";
            break;
        case "04":
            $slide = "/assets/images/slides_meses/abril.jpg";
            break;
         case "05":
            $slide = "/assets/images/slides_meses/maio.jpg";
            break;
        case "06":
            $slide = "/assets/images/slides_meses/junho.jpg";
            break;
        case "07":
            $slide = "/assets/images/slides_meses/julho.jpg";
            break;
        case "08":
            $slide = "/assets/images/slides_meses/agosto.jpg";
            break;
        case "09":
            $slide = "/assets/images/slides_meses/setembro.jpg";
            break;
        case "10":
            $slide = "/assets/images/slides_meses/outubro.jpg";
            break;
        case "11":
            $slide = "/assets/images/slides_meses/novembro.jpg";
            break;
        case "12":
            $slide = "/assets/images/slides_meses/dezembro.jpg";
            break;
        default:
            $slide = "/assets/images/jira.jpg";
     }
 
     return $slide;
 }

/**
 * @param string $image
 * @param int $width
 * @param int|null $height
 * @return string
 */
function image(?string $image, int $width, int $height = null): ?string
{
    if ($image) {
        return url() . "/" . (new \Source\Support\Thumb())->make($image, $width, $height);
    }

    return null;
}

/**
 * @param string|null $photo
 * @param string $avatar
 * @return string
 */
function photoList(?string $photo, string $avatar = 'avatar.jpg'): string
{
    $avatarUrl = url("/storage/images/{$avatar}");
    
    if ($photo && file_exists(CONF_UPLOAD_DIR . "/{$photo}")) {
        $photoUrl = url(CONF_UPLOAD_DIR . "/{$photo}");
        $thumbUrl = image($photo, 30, 30);
    } else {
        $photoUrl = $avatarUrl;
        $thumbUrl = $avatarUrl;
    }

    return "<a href=\"{$photoUrl}\" target=\"_blank\">
                <img src=\"{$thumbUrl}\" class=\"rounded-circle float-left\" height=\"30\" width=\"30\">
            </a>";
}

/**
 * Gera o HTML de uma imagem de perfil ou uma imagem padrão.
 * Verifica a existência do ficheiro e retorna a URL correta para a imagem e a sua miniatura.
 *
 * @param string|null $photoPath O caminho da foto guardado no banco de dados.
 * @param int $width A largura da miniatura desejada.
 * @param int|null $height A altura da miniatura desejada.
 * @param string $defaultAvatar O nome do ficheiro de avatar padrão.
 * @return string O HTML completo da tag <img>.
 */
function userPhoto(?string $photoPath, int $width, int $height = null, string $defaultAvatar = 'avatar.jpg'): string
{
    // Define a URL do avatar padrão
    $defaultImageUrl = theme("/assets/images/{$defaultAvatar}", CONF_VIEW_ADMIN);

    // Verifica se um caminho de foto foi fornecido
    if ($photoPath) {
        // Constrói o caminho absoluto no disco para verificar se o ficheiro existe
        $absolutePath = CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$photoPath}";
        
        if (file_exists($absolutePath)) {
            // Se o ficheiro existe, gera a URL da miniatura usando a helper 'image()'
            $imageUrl = image($photoPath, $width, $height);
        } else {
            // Se o ficheiro não existe, usa a imagem padrão
            $imageUrl = $defaultImageUrl;
        }
    } else {
        // Se nenhum caminho de foto foi fornecido, usa a imagem padrão
        $imageUrl = $defaultImageUrl;
    }
    
    return "<img src=\"{$imageUrl}\" width=\"{$width}\" height=\"{$height}\" class=\"rounded-circle float-left\">";
}

/**
 * Gera o HTML de uma imagem de capa de evento ou uma imagem padrão.
 * Verifica a existência do ficheiro e retorna a URL correta para a imagem e a sua miniatura.
 *
 * @param string|null $coverPath O caminho da capa guardado no banco de dados.
 * @param int $width A largura da miniatura desejada.
 * @param int|null $height A altura da miniatura desejada.
 * @param string $defaultCover O nome do ficheiro de capa padrão.
 * @return string O HTML completo da tag <img>.
 */
function eventCover(?string $coverPath, int $width, int $height = null, string $defaultCover = 'avatar_product.png'): string
{
    // Define a URL do avatar padrão
    $defaultImageUrl = theme("/assets/images/{$defaultCover}", CONF_VIEW_ADMIN);

    // Verifica se um caminho de foto foi fornecido
    if ($coverPath) {
        // Constrói o caminho absoluto no disco para verificar se o ficheiro existe
        $absolutePath = CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$coverPath}";
        
        if (file_exists($absolutePath)) {
            // Se o ficheiro existe, gera a URL da miniatura usando a helper 'image()'
            $imageUrl = image($coverPath, $width, $height);
        } else {
            // Se o ficheiro não existe, usa a imagem padrão
            $imageUrl = $defaultImageUrl;
        }
    } else {
        // Se nenhum caminho de foto foi fornecido, usa a imagem padrão
        $imageUrl = $defaultImageUrl;
    }
    
    return "<img src=\"{$imageUrl}\" width=\"{$width}\" height=\"{$height}\" class=\"img-thumbnail float-left j_profile_image\">";
}

/**
 * Gera a tag HTML <img> para um avatar (imagem de perfil), com fallback para uma imagem padrão.
 * A função é flexível para ser usada com qualquer entidade (usuários, clientes, empresas) e em 
 * diferentes camadas da aplicação (admin, app, web).
 *
 * @param string|null $imagePath O caminho da imagem, geralmente vindo do banco de dados.
 * @param int $width A largura da imagem em pixels.
 * @param int|null $height A altura da imagem. Se nulo, será igual à largura.
 * @param string $viewLayer A constante da camada de view (ex: CONF_VIEW_ADMIN).
 * @param array $attributes Um array associativo de atributos HTML extras para a tag <img>.
 * @param string $defaultImage O nome do arquivo de imagem padrão.
 * @return string A tag <img> completa.
 */
function avatar(
    ?string $imagePath,
    int $width,
    ?int $height,
    string $viewLayer,
    array $attributes = [],
    string $defaultImage = 'avatar.jpg'
): string {
    // 1. Determina a URL da imagem (padrão ou a da entidade)
    $imageUrl = theme("/assets/images/{$defaultImage}", $viewLayer);

    if ($imagePath) {
        $absolutePath = CONF_PROJECT_ROOT . "/" . CONF_UPLOAD_DIR . "/{$imagePath}";
        if (file_exists($absolutePath) && !is_dir($absolutePath)) {
            $imageUrl = image($imagePath, $width, $height);
        }
    }

    // 2. Monta os atributos HTML da imagem
    $defaultAttributes = [
        'src' => $imageUrl,
        'width' => $width,
        'height' => $height ?? $width,
        'alt' => 'Avatar' // Alt mais genérico
    ];
    
    $finalAttributes = array_replace($defaultAttributes, $attributes);

    // 3. Constrói a string de atributos para a tag HTML
    $attributesString = '';
    foreach ($finalAttributes as $key => $value) {
        $attributesString .= ' ' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
    }

    return "<img{$attributesString}>";
}


/**
 * @param string $status
 * @return string
 */
function statusBadge(string $status): string
{
    if($status == 'disabled'):
        return '<span class="badge text-bg-danger ms-2">DESATIVADO</span>';
    else:
        return '<span class="badge text-bg-success text-light ms-2">ATIVO</span>';
    endif;
}

/**
 * Gera um badge de status para eventos.
 * @param string $status
 * @return string
 */
function eventStatusBadge(string $status): string
{
    $status = strtolower($status);
    
    switch ($status) {
        case 'agendado':
            return '<h5><span class="badge fw-semibold text-bg-primary p-2">Agendado</span></h5>';
        case 'realizado':
            return '<h5><span class="badge fw-semibold text-bg-success text-white p-2">Realizado</span></h5>';
        case 'ao vivo':
            return '<h5><span class="badge fw-semibold text-bg-danger p-2"><i class="bi bi-broadcast me-1"></i>Ao Vivo</span></h5>';
        case 'cancelado':
            return '<h5><span class="badge fw-semibold text-bg-danger p-2">Cancelado</span></h5>';
        default:
            return '<h5><span class="badge fw-semibold text-bg-dark p-2">Indefinido</span></h5>';
    }
}

/**
 * Gera as opções de <option> para o status do usuário.
 * @param string|null $currentStatus O status atual para pré-selecionar a opção.
 * @return string
 */
function user_status_options(?string $currentStatus): string
{
    $statuses = [
        'registered' => 'Registrado',
        'actived' => 'Ativado',
        'disabled' => 'Desativado'
    ];

    $htmlOptions = "";
    foreach ($statuses as $value => $text) {
        $selected = ($currentStatus === $value) ? "selected" : "";
        $htmlOptions .= "<option value=\"{$value}\" {$selected}>{$text}</option>";
    }

    return $htmlOptions;
}

/**
 * Gera as opções de <option> para o select de cargos, agrupados por descrição.
 * @return string
 */
function grouped_position_options_select(): string
{
    // Busca todos os cargos ativos, ordenados pelo grupo (description) e depois pelo nome
    $positions = (new \Source\Domain\User\Models\UserPosition())
        ->find("status = 'actived'")
        ->order("description ASC, position_name ASC")
        ->fetch(true);

    if (!$positions) {
        return "";
    }

    // Agrupa os cargos pela descrição
    $groupedPositions = [];
    foreach ($positions as $position) {
        $groupName = $position->description ?: 'Outros'; // Agrupa cargos sem descrição em "Outros"
        $groupedPositions[$groupName][] = $position;
    }

    // Gera o HTML com <optgroup>
    $htmlOptions = "";
    foreach ($groupedPositions as $groupName => $groupPositions) {
        $htmlOptions .= "<optgroup label='GRUPO: {$groupName}'>";
        foreach ($groupPositions as $position) {
            $htmlOptions .= "<option value='{$position->id}'>{$position->position_name}</option>";
        }
        $htmlOptions .= "</optgroup>";
    }

    return $htmlOptions;
}

/**
 * ################
 * ###  BUTTONS ###
 * ################
 */

/**
 * Gera um botão ou um link estilizado como botão.
 * @param array $options
 * @return string|null
 */
function buttonOld(array $options): ?string
{
    // Valores padrão
    $defaults = [
        "name" => "Button",
        "icon" => "person",
        "btncolor" => "success",
        "placement" => "top",
        "custom" => "dark",
        "data-bs-toggle" => "modal",
        "data-bs-target" => "#confirmFinishModal",
        "title" => "SIGECINFO",
        "tabindex" => "1",
        "accesskey" => "g",
        "href" => null,
        "disabled_count" => null,
        "is_circle" => false // Para o estilo arredondado
    ];

    $attr = array_merge($defaults, $options);

    $tag = $attr["href"] ? "a" : "button";
    $href = $attr["href"] ? "href=\"" . url($attr["href"]) . "\"" : "";
    $role = $attr["href"] ? "role=\"button\"" : "";
    
    $countBadge = $attr["disabled_count"] ? "<span class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\">{$attr["disabled_count"]}</span>" : "";
    $iconHtml = "<span class=\"btn-label\"><i class=\"bi bi-{$attr["icon"]}\"></i></span>";
    $textHtml = " <u>" . substr($attr["name"], 0, 1) . "</u>" . substr($attr["name"], 1, 12);
    
    $class = "btn btn-sm btn-outline-{$attr["btncolor"]} fw-semibold me-3 position-relative" . ($attr["is_circle"] ? " rounded-circle" : " rounded-pill");

    return "<{$tag} {$href} {$role} class=\"{$class}\" data-bs-toggle-tooltip=\"tooltip\" data-bs-custom-class=\"custom-tooltip-{$attr["custom"]}\" data-bs-placement=\"{$attr["placement"]}\" data-bs-title=\"{$attr["title"]}\" tabindex=\"{$attr["tabindex"]}\" accesskey=\"{$attr["accesskey"]}\">
    {$iconHtml}
    {$textHtml}
    {$countBadge}
            </{$tag}>";
}

/**
 * Gera um botão ou link estilizado com Bootstrap.
 * (Versão final e segura)
 *
 * @param array $params Parâmetros para o botão.
 * @return string O HTML do botão.
 */
function button(array $params): string
{
    $href = $params['href'] ?? null;
    $tag = $href ? 'a' : 'button';
    $countBadge = $params['disabled_count'] ?? null;

    $type = $params['type'] ?? ($tag === 'button' ? 'button' : null);

    $name = $params['name'] ?? 'Button';
    $icon = $params['icon'] ?? null;
    $btnColor = $params['btncolor'] ?? 'primary';
    $class = $params['class'] ?? '';
    $badge = $params['disabled_count'] ?? null;
    
    $attributes = '';
    $finalClass = "btn btn-outline-{$btnColor} btn-sm fw-semibold rounded-pill " . $class;
    $attributes .= 'class="' . trim($finalClass) . ' me-3"';

    if ($href) {
        $attributes .= ' href="' . htmlspecialchars(url($href), ENT_QUOTES, 'UTF-8') . '"';
    }

    // Adiciona o atributo 'type' apenas para a tag <button>
    if ($type && $tag === 'button') {
        $attributes .= ' type="' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '"';
    }

    if (isset($params['id'])) {
        $attributes .= ' id="' . htmlspecialchars($params['id'], ENT_QUOTES, 'UTF-8') . '"';
    }

    if (isset($params['data-bs-toggle'])) {
        $attributes .= ' data-bs-toggle="' . htmlspecialchars($params['data-bs-toggle'], ENT_QUOTES, 'UTF-8') . '"';
    }
    if (isset($params['data-bs-target'])) {
        $attributes .= ' data-bs-target="' . htmlspecialchars($params['data-bs-target'], ENT_QUOTES, 'UTF-8') . '"';
    }

    if (isset($params['onclick'])) {
        $attributes .= ' onclick="' . htmlspecialchars($params['onclick'], ENT_QUOTES, 'UTF-8') . '"';
    }

    // Add tooltip attributes if a title is provided
    if (isset($params['title'])) {
        $attributes .= ' data-bs-toggle-tooltip="tooltip"';
        $attributes .= ' data-bs-placement="' . ($params['placement'] ?? 'top') . '"';
        $attributes .= ' data-bs-custom-class="' . ($params['custom'] ?? 'custom-tooltip-dark') . '"';
        $attributes .= ' data-bs-title="' . htmlspecialchars($params['title'], ENT_QUOTES, 'UTF-8') . '"';
    }

    $countBadge = $badge ? "<span class=\"position-absolute rounded-pill badge text-bg-danger\">{$badge}</span>" : "";

    $iconHtml = $icon ? "<i class='bi bi-{$icon}'></i>" : "";

    return "<{$tag} {$attributes}>{$iconHtml}{$name}{$countBadge}</{$tag}>";
}
 


/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_fmt(?string $date, string $format = "d/m/Y H\hi"): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format($format);
}

/**
 * @param string $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_now(string $format = "d/m/Y"): string
{
    return (new DateTime("now"))->format($format);
}

/**
 * @param string $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_fmt_null(?string $date, string $format = "d/m/Y"): string
{
    $date = (empty($date) ? "" : $date);
    if(empty($date)) {
        return '';
    } else {
        return (new DateTime($date))->format($format);
    }
}

/**
 * @param string $date
 * @return string
 * @throws Exception
 */
function date_fmt_app(?string $date): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format(CONF_DATE_APP);
}

/**
 * @param string|null $date
 * @return string|null
 */
function date_fmt_back(?string $date): ?string
{
    if (!$date) {
        return null;
    }

    if (strpos($date, " ")) {
        $date = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $date[0]))) . " " . $date[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
 * @param string $password
 * @return string
 */
function passwd(string $password): string
{
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }

    return password_hash($password, PASSWORD_DEFAULT, ["cost" => 10]);
}

/**
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * @param string $hash
 * @return bool
 */
function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

function level_badge(string $levelName): string
{
    $badges = [
        'Usuario' => '<span class="badge text-bg-primary ms-2">User</span>',
        'Usuario Editor' => '<span class="badge text-bg-light ms-2">Edit*</span>',
        'Editor' => '<span class="badge text-bg-info ms-2">Edit</span>',
        'Editor Administrador' => '<span class="badge text-bg-success ms-2">Adm*</span>',
        'Administrador do Sistema' => '<span class="badge text-bg-warning ms-2">Adm</span>'
    ];

    return $badges[$levelName] ?? '<span class="badge text-bg-secondary ms-2">?</span>';
}

function status_name(string $status): string
{
    $names = [
        'registered' => 'REGISTRADO',
        'actived' => 'ATIVADO',
        'disabled' => 'DESATIVADO'
    ];

    return $names[$status] ?? '';
}

    /**
     * @param string $status
     * @return null|string
     */
    function statusSpan(string $status): ?string
    {

    if ($status == "registered") {
        return '<span class="badge fw-semibold text-bg-warning pt-2 pb-2 mt-2" data-bs-toggle-tooltip="tooltip" 
                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-'.color_month().'" data-bs-title="Falta acesso ao e-mail de confirmação">
                    Registrado</span>';
    } elseif ($status == "actived") {
        return '<span class="badge fw-semibold text-bg-success text-light pt-2 pb-2 mt-2" data-bs-toggle-tooltip="tooltip" 
                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-'.color_month().'" data-bs-title="Usuário confirmou">ATIVADO</span>';
    } else {
        return '<span class="badge fw-semibold text-bg-danger pt-2 pb-2 mt-2">DESATIVADO</span>';
    }
    return null; 
    }
    

/**
 * ###################
 * ###  BREADCRUMB ###
 * ###################
 */
   
 /**
 * Gera o HTML do breadcrumb a partir de um array.
 * @param array $crumbs Array de "migalhas", onde cada uma é um array com "title" e "link" (opcional).
 * @param string $homeIcon O HTML para o ícone da página inicial.
 * @return string O HTML completo do breadcrumb.
 */

function breadcrumb(array $crumbs = [], string $homeIcon = '<i class="bi bi-house-door-fill"></i>'): string
{
    $html = '<div class="container-fluid my-3"><nav aria-label="breadcrumb"><ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">';

    // Adiciona o link "Início" automaticamente
    $base_url = (strpos($_GET['route'] ?? '/', 'painel') === 1 ? url('/painel/controle') : url('/app/home'));
    $html .= '<li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none" href="' . $base_url . '">' . $homeIcon . ' Início</a></li>';

    // Itera sobre as migalhas passadas
    foreach ($crumbs as $index => $crumb) {
        // A última migalha é a página ativa e não tem link
        if ($index === array_key_last($crumbs)) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . $crumb['title'] . '</li>';
        } else {
            $link = isset($crumb['link']) ? $crumb['link'] : '#';
            $html .= '<li class="breadcrumb-item"><a class="link-body-emphasis fw-semibold text-decoration-none" href="' . $link . '">' . $crumb['title'] . '</a></li>';
        }
    }

    $html .= '</ol></nav></div>';
    return $html;
}
/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */

/**
 * @return string
 */
function csrf_input(): string
{
    $session = new \Source\Core\Session();
    $session->csrf();
    return "<input type='hidden' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
}

/**
 * @param $request
 * @return bool
 */
function csrf_verify($request): bool
{
    $session = new \Source\Core\Session();
    if (empty($session->csrf_token) || empty($request['csrf']) || $request['csrf'] != $session->csrf_token) {
        return false;
    }
    return true;
}

/**
 * @return null|string
 */
function flash(): ?string
{
    $session = new \Source\Core\Session();
    if ($flash = $session->flash()) {
        return $flash;
    }
    return null;
}

/**
 * @param string $key
 * @param int $limit
 * @param int $seconds
 * @return bool
 */
function request_limit(string $key, int $limit = 5, int $seconds = 60): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests < $limit) {
        $session->set($key, [
            "time" => time() + $seconds,
            "requests" => $session->$key->requests + 1
        ]);
        return false;
    }

    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests >= $limit) {
        return true;
    }

    $session->set($key, [
        "time" => time() + $seconds,
        "requests" => 1
    ]);

    return false;
}

/**
 * @param string $field
 * @param string $value
 * @return bool
 */
function request_repeat(string $field, string $value): bool
{
    $session = new \Source\Core\Session();
    if ($session->has($field) && $session->$field == $value) {
        return true;
    }

    $session->set($field, $value);
    return false;
}

/**
 * Garante que uma URL tenha um esquema (http:// ou https://).
 * Se não tiver, adiciona "https://".
 *
 * @param string|null $url A URL a ser verificada.
 * @return string|null A URL com o esquema garantido, ou null se a entrada for nula.
 */
function ensure_url_scheme(?string $url): ?string
{
    if ($url === null || $url === '') {
        return null;
    }

    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        return "https://" . $url;
    }

    return $url;
}