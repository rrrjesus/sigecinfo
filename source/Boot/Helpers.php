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
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
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
 * @return \Source\Models\Company\User|null
 */
function user(): ?\Source\Models\Company\User
{
    return \Source\Models\Auth::user();
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
 * @return null|string
 */
function photoList(?string $photo, string $avatar = 'avatar.jpg'): ?string
{
    if($photo && file_exists(CONF_UPLOAD_DIR.'/'.$photo)){
        return '<a href="../'.CONF_UPLOAD_DIR.'/'.$photo.'" target="_blank">
                <img src="'.image($photo, 30,30).'" class="rounded-circle float-left"></a>';
    }else{
        return '<a href="../storage/images/'.$avatar.'" target="_blank">
                <img src="../storage/images/'.$avatar.'" class="rounded-circle float-left"
                height="30" width="30"></a>';
    }
    return null;
}

/**
 * @param string|null $photo
 * @return null|string
 */

function photoListDisabled(?string $photo, string $avatar = 'avatar.jpg'): ?string
{
    if($photo && file_exists('themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$photo)){
        return '<a href="../../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$photo.'" target="_blank">
                <img src="../../themes/'.CONF_VIEW_ADMIN.'/assets/images/assinatura/'.$photo.'" height="40" width="40" class="img-thumbnail rounded-circle float-left"></a>';
    }else{
        return '<a href="../../storage/images/'.$avatar.'" target="_blank">
                <img src="../../storage/images/'.$avatar.'" class="img-thumbnail rounded-circle float-left"
                height="40" width="40"></a>';
    }
    return null;
}

/**
 * @param string $status
 * @return string
 */
function statusBadge(string $status): string
{
    if($status == 'actived'):
        return '<span class="badge text-bg-success text-light ms-2">ATIVO</span>';
    elseif($status == 'disabled'):
        return '<span class="badge text-bg-danger ms-2">INATIVO</span>';
    else:
            return '<span class="badge text-bg-danger ms-2">BAIXA</span>';
    endif;
}

/**
 * ################
 * ###  BUTTONS ###
 * ################
 */

 function buttonLink(string $href = "/", string $placement = "top", string $title = "Siegcinfo", string $btncolor = "success", string $icon = "person", string $name = "Button", string $tabindex = "l", string $accesskey = "l", string $target =""): ?string
 {
    return '<a role="button" href="'.url($href).'" data-bs-togglee="tooltip" data-bs-placement="'.$placement.'" data-bs-custom-class="custom-tooltip-success"
    data-bs-title="'.$title.'" class="btn btn-outline-'.$btncolor.' btn-sm position-relative rounded-pill fw-semibold me-3" tabindex="'.$tabindex.'" accesskey="'.$accesskey.'" target="'.$target.'" rel="noopener"><span class="btn-label"><i class="bi bi-'.$icon.'"></i></span>  <u>'.substr($name,0,1).'</u>'.substr($name,1,12).'</a>';
 }

 function buttonLinkCircle(string $href = "/", string $placement = "top", string $title = "Siegcinfo", string $btncolor = "success", string $icon = "person", string $name = "Button", string $tabindex = "l", string $accesskey = "l", string $target =""): ?string
 {
    return '<a role="button" href="'.url($href).'" data-bs-togglee="tooltip" data-bs-placement="'.$placement.'" data-bs-custom-class="custom-tooltip-success"
    data-bs-title="'.$title.'" class="btn btn-outline-'.$btncolor.' btn-sm position-relative rounded-pill fw-semibold me-3" tabindex="'.$tabindex.'" accesskey="'.$accesskey.'" target="'.$target.'" rel="noopener"><i class="bi bi-'.$icon.'"></i>  <u>'.substr($name,0,1).'</u>'.substr($name,1,12).'</a>';
 }

 function buttonLinkDisabled(string $href = "/", string $placement = "top", string $title = "Siegcinfo", string $btncolor = "secondary", string $icon = "person", string $name = "Button", string $tabindex = "l", string $accesskey = "d", string $count = ""): ?string
 {
    return '<a role="button" href="'.url($href).'" data-bs-togglee="tooltip" data-bs-placement="'.$placement.'" data-bs-custom-class="custom-tooltip-success"
    data-bs-title="'.$title.'" class="btn btn-outline-'.$btncolor.' btn-sm position-relative rounded-pill fw-semibold me-3" tabindex="'.$tabindex.'" accesskey="'.$accesskey.'"><span class="btn-label"><i class="bi bi-'.$icon.' text-danger"></i></span>  <u>'.substr($name,0,1).'</u>'.substr($name,1,12).'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'.$count.'</span></a>';
 }

 function button(?string $placement = "top", string $title = "Siegcinfo", string $btncolor = "success", string $icon = "person", string $name = "Button", string $tabindex = "1", string $accesskey = "g"): string
 {
    return '<button data-bs-togglee="tooltip" data-bs-placement="'.$placement.'" data-bs-custom-class="custom-tooltip-success" data-bs-title="'.$title.'" 
        class="btn btn-sm btn-outline-'.$btncolor.' rounded-pill fw-semibold me-3" tabindex="'.$tabindex.'" accesskey="'.$accesskey.'"><span class="btn-label"><i class="bi bi-'.$icon.'"></i></span> <u>'.substr($name,0,1).'</u>'.substr($name,1,12).'</button>';
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

    /**
     * @param string $status
     * @return null|string
     */
    function statusSpan(string $status): ?string
    {

    if ($status == "registered") {
        return '<span class="badge fw-semibold text-bg-warning pt-2 pb-2 mt-2" data-bs-togglee="tooltip" 
                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-'.color_month().'" data-bs-title="Falta acesso ao e-mail de confirmação">
                    Registrado</span>';
    } elseif ($status == "confirmed") {
        return '<span class="badge fw-semibold text-bg-success text-light pt-2 pb-2 mt-2" data-bs-togglee="tooltip" 
                    data-bs-placement="top" data-bs-custom-class="custom-tooltip-'.color_month().'" data-bs-title="Usuário confirmou">CONFIRMADO</span>';
    } else {
        return '<span class="badge fw-semibold text-bg-danger pt-2 pb-2 mt-2">INATIVO</span>';
    }
    return null; 
    }
    

/**
 * ###################
 * ###  BREADCRUMB ###
 * ###################
 */
   
 /**
 * @return string
 */

function breadcrumbAdmin(string $urls = null,string $namepage = null,string $name = null): string
{
    if($urls){
        return '<li class="breadcrumb-item">
                    <a class="link-body-emphasis fw-semibold text-decoration-none" href="'.url("/painel/{$urls}").'">' .$namepage.'</a></li>
                </li>
                <li class="breadcrumb-item active" aria-current="page">'.$name.'</li>';
    }
    return null;
}

 /**
 * @return string
 */

 function breadcrumbApp(string $urls = null,string $namepage = null,string $name = null): string
 {
    if($urls){
        return '<li class="breadcrumb-item">
                    <a class="link-body-emphasis fw-semibold text-decoration-none" href="'.url("/beta/{$urls}").'">' .$namepage.'</a></li>
                </li>
                <li class="breadcrumb-item active" aria-current="page">'.$name.'</li>';
    }
     return null;
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