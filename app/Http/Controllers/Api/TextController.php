<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller\UserController;
use Illuminate\Http\Request;
use App\Jobs\SendNotificationEmail;

class TextController extends Controller
{
    private $blacklist = [
        'estrupo',
        'estrupar',
        'estrupa',
        'caralho',
        'bunda',
        'hitler',
        'idiota',
        'bunda',
        'Idiota',
        'Desgraçado',
        'cadela',
        'sangrento',
        'besteira',
        'merda',
        'besteira',
        'filho da puta',
        'chupador de pau',
        'besteira',
        'boceta',
        'cyka blyat',
        'droga',
        'caramba',
        'pau',
        'idiota',
        'sapatona',
        'filho da puta',
        'Porra',
        'Maldito',
        'caramba',
        'inferno',
        'puta merda',
        'merda',
        'na merda',
        'kike',
        'filho da puta',
        'cu',
        'anus',
        'toba',
        'puta',
        'foda',
        'foda-se',
        'foder',
        'pariu',
        'nazista',
        'nazismo',
        'neonazismo',
        'neonazista',
        'odeio negro',
        'hitler'
    ];

    // function censorText($text) {
    //     foreach ($this->blacklist as $word) {
    //         // Cria um padrão regex para substituir palavras de forma case-insensitive
    //         $pattern = '/(' . preg_quote($word, '/') . ')(?=\W|\d|$)/i';
    //         // Mantém a primeira letra intacta e substitui as demais por '*'
    //         $replacement = substr($word, 0, 1) . str_repeat('*', strlen($word) - 1);
    //         // Realiza a substituição no texto original
    //         $text = preg_replace($pattern, $replacement, $text);
    //     }
    //     return $text;
    // }
    function censorText($text) {
        foreach ($this->blacklist as $word) {
            // Cria um padrão regex para substituir apenas palavras inteiras
            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
            // Mantém a primeira letra e substitui o restante por '*'
            $replacement = substr($word, 0, 1) . str_repeat('*', strlen($word) - 1);
            // Realiza a substituição
            $text = preg_replace($pattern, $replacement, $text);
        }
        return $text;
    }

    function hasOffensiveWords($text) {
        foreach ($this->blacklist as $word) {
            // Cria um padrão regex para verificar palavras de forma case-insensitive
            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
            // Verifica se o padrão existe no texto
            if (preg_match($pattern, $text)) {
                return true; // Existe uma palavra ofensiva
            }
        }
        return false; // Não foi encontrada nenhuma palavra ofensiva
    }
    
    
    function clearText($text) {
        // Padrões para links, menções de usuários e hashtags
        $padraoLink = '/(https?:\/\/[^\s]+)/';
        $padraoTagUser = '/(?:\s|^)(@[a-zA-Z0-9_]+)/';
        $padraoHashtag = '/(?<!\S)(#[\wÀ-ÿ]+)/u';
    
        // Escapa as tags HTML
        $textoFormatado = $this->escapeHtmlWithAllowedTags($text);
    
        // Formata links como <a>
        $textoFormatado = preg_replace_callback($padraoLink, function ($matches) {
            $url = $matches[0];
            return "<a href='{$url}' target='_blank' style='word-wrap: break-word;'>{$url}</a>";
        }, $textoFormatado);
    
    
        // Formata hashtags
        $textoFormatado = preg_replace_callback($padraoHashtag, function ($matches) {
            $hashtag = substr($matches[0], 1); // Remove o "#"
            return "<a href='" . config("app.pacoca_url") ."/hashtag/{$hashtag}' target='_blank' style='word-wrap: break-word;'>{$matches[0]}</a>";
        }, $textoFormatado);
    
        // return $textoFormatado;
        return $this->substituirEmojis($textoFormatado);
    }

    function substituirEmojis($texto) {
        $emojis = [
            ':pacoca_coracao:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/coracao.png' class='emoji' alt=':pacoca_coracao:' data-title=':pacoca_coracao:' style='height: 27px;'>",
            ':pacoca_lingua:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/lingua.png' class='emoji' alt=':pacoca_lingua:' data-title=':pacoca_lingua:' style='height: 27px;'>",
            ':pacoca_mao:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/mao.png' class='emoji' alt=':pacoca_mao:' data-title=':pacoca_mao:' style='height: 27px;'>",
            ':pacoca_oculos1:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/oculos1.png' class='emoji' alt=':pacoca_oculos1:' data-title=':pacoca_oculos1:' style='height: 27px;'>",
            ':pacoca_vomito_arco_iris:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/vomito_arco_iris.png' class='emoji' alt=':pacoca_vomito_arco_iris:' data-title=':pacoca_vomito_arco_iris:' style='height: 27px;'>",
            ':pacoca_sorriso:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/sorriso.png' class='emoji' alt=':pacoca_sorriso:' data-title=':pacoca_sorriso:' style='height: 27px;'>",
            ':pacoca_palavrao:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/palavrao.png' class='emoji' alt=':pacoca_palavrao:' data-title=':pacoca_palavrao:' style='height: 27px;'>",
            ':pacoca_duvida:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/duvida.png' class='emoji' alt=':pacoca_duvida:' data-title=':pacoca_duvida:' style='height: 29px;'>",
            ':pacoca_choro1:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/choro.png' class='emoji' alt=':pacoca_choro1:' data-title=':pacoca_choro1:' style='height: 25px;'>",
            ':pacoca_canto:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/canto.png' class='emoji' alt=':pacoca_canto:' data-title=':pacoca_canto:' style='height: 25px;'>",
            ':pacoca_raiva1:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/raiva.png' class='emoji' alt=':pacoca_raiva1:' data-title=':pacoca_raiva1:' style='height: 25px;'>",
            ':pacoca_beijo_coracao:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/beijo_coracao.png' class='emoji' alt=':pacoca_beijo_coracao:' data-title=':pacoca_beijo_coracao:' style='height: 25px;'>",
            ':pacoca_uau:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/uau.png' class='emoji' alt=':pacoca_uau:' data-title=':pacoca_uau:' style='height: 25px;'>",
            ':pacoca_tremendo:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/tremendo.png' class='emoji' alt=':pacoca_tremendo:' data-title=':pacoca_tremendo:' style='height: 25px;'>",
            ':pacoca_dormindo:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/dormindo.png' class='emoji' alt=':pacoca_dormindo:' data-title=':pacoca_dormindo:' style='height: 25px;'>",
            ':pacoca_baba:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/baba.png' class='emoji' alt=':pacoca_baba:' data-title=':pacoca_baba:' style='height: 25px;'>",
            ':pacoca_lagrima:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/lagrima.png' class='emoji' alt=':pacoca_lagrima:' data-title=':pacoca_lagrima:' style='height: 25px;'>",
            ':pacoca_diabinho1:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/diabinho.png' class='emoji' alt=':pacoca_diabinho1:' data-title=':pacoca_diabinho1:' style='height: 26px;'>",
            ':pacoca_anjo1:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/anjo.png' class='emoji' alt=':pacoca_anjo1:' data-title=':pacoca_anjo1:' style='height: 26px;'>",
            ':pacoca_choro_riso:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/zack/choro_riso.png' class='emoji' alt=':pacoca_choro_riso:' data-title=':pacoca_choro_riso:' style='height: 26px;'>",

            ':pacoca:' => "<img src='" . config("app.pacoca_url") . "/img/pacoca-sem-braco.png' class='emoji' alt=':pacoca:' data-title=':pacoca:' style='height: 25px; width: 25px'>",
            ':pacoca_corpo:' => "<img src='" . config("app.pacoca_url") . "/img/pacoca-com-braco.png' class='emoji' alt=':pacoca_corpo:' data-title=':pacoca_corpo:' style='height: 25px; width: 32px'>",
            ':pacoca_fundo:' => "<img src='" . config("app.pacoca_url") . "/img/pacoca-sem-braco-rounded.png' class='emoji' alt=':pacoca_fundo:' data-title=':pacoca_fundo:' style='height: 25px; width: 25px'>",
            ':pacoca_fundo_braco:' => "<img src='" . config("app.pacoca_url") . "/img/pacoca-com-braco-rounded.png' class='emoji' alt=':pacoca_fundo_braco:' data-title=':pacoca_fundo_braco:' style='height: 25px; width: 25px'>",
            ':pacoca_cat:' => "<img src='" . config("app.pacoca_url") . "/img/nyan-cat.gif' class='emoji' alt=':pacoca_cat:' data-title=':pacoca_cat:' style='margin-right: -14px; height: 20px; width: 40px';>",
            ':pacoca_404:' => "<img src='" . config("app.pacoca_url") . "/img/errors/page-not-found.jpg' class='emoji' alt=':pacoca_404:' data-title=':pacoca_404:' style='height: 30px; width: 30px'>",
            ':pacoca_500:' => "<img src='" . config("app.pacoca_url") . "/img/errors/pato.png' class='emoji' alt=':pacoca_500:' data-title=':pacoca_500:' style='height: 25px; width: 25px'>",
            ':bochecha:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/bochecha.png' class='emoji' alt=':bochecha:' data-title=':bochecha:' style='height: 25px; width: 25px'>",

            ':pacoca_choro:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/choro.png' class='emoji' alt=':pacoca_choro:' data-title=':pacoca_choro:' style='height: 30px; width: 30px'>",
            ':pacoca_fome:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/fome.png' class='emoji' alt=':pacoca_fome:' data-title=':pacoca_fome:' style='height: 30px; width: 30px'>",
            ':pacoca_raiva:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/raiva.png' class='emoji' alt=':pacoca_raiva:' data-title=':pacoca_raiva:' style='height: 30px; width: 30px'>",
            ':pacoca_beijo:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/beijo.png' class='emoji' alt=':pacoca_beijo:' data-title=':pacoca_beijo:' style='height: 30px; width: 30px'>",

            ':pacoca_caveira:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/caveira.png' class='emoji' alt=':pacoca_caveira:' data-title=':pacoca_caveira:' style='height: 30px; width: 30px'>",
            ':pacoca_palhaco:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/palhaco.png' class='emoji' alt=':pacoca_palhaco:' data-title=':pacoca_palhaco:' style='height: 30px; width: 30px'>",
            ':pacoca_oculos:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/oculos.png' class='emoji' alt=':pacoca_oculos:' data-title=':pacoca_oculos:' style='height: 30px; width: 30px'>",
            ':pacoca_diabinho:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/diabinho.png' class='emoji' alt=':pacoca_diabinho:' data-title=':pacoca_diabinho:' style='height: 30px; width: 30px'>",
            ':pacoca_anjo:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/anjo.png' class='emoji' alt=':pacoca_anjo:' data-title=':pacoca_anjo:' style='height: 28px; width: 35px'>",
            ':pacoca_assustado:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/assustado.png' class='emoji' alt=':pacoca_assustado:' data-title=':pacoca_assustado:' style='height: 30px;'>",
            ':pacoca_derretendo:' => "<img src='" . config("app.pacoca_url") . "/img/emoji/derretendo.png' class='emoji' alt=':pacoca_derretendo:' data-title=':pacoca_derretendo:' style='height: 30px;'>",
        ];
        
        
        return str_replace(array_keys($emojis), array_values($emojis), $texto);
    }
    
    
    
    // Função auxiliar para escapar HTML
    function escapeHtmlWithAllowedTags($text, $allowed_tags = ['b', 'a', 'br', 'p']) {
        // Primeiro, escapa tudo
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        // Depois, para cada tag permitida, "desescapa"
        foreach ($allowed_tags as $tag) {
            // Abrindo tag
            $text = str_replace("&lt;{$tag}&gt;", "<{$tag}>", $text);
            // Fechando tag
            $text = str_replace("&lt;/{$tag}&gt;", "</{$tag}>", $text);
        }

        return $text;
    }

    public function verifyUserNameAndSendNotification($text, $post){
        $padrao_tag_user = '/(@[^\s]+)/';
        $padrao_tag_user = '/(@[a-zA-Z0-9_]+)/';

        return preg_replace_callback($padrao_tag_user, function ($match) use ($post) {
            $notificationController = new NotificationController();
            $username = substr($match[0], 1); // Remove o "@" do início do username

            $user_controller = app(UserController::class);
            $user = $user_controller->getUserByUserName($username);
            if($user){
                $img = auth()->user()->img_account ? auth()->user()->img_account : '../img/img-account.png';
                $text = auth()->user()->name . " marcou você em uma publicação";
                // $link1 = "/" . auth()->user()->user_name;
                $link2 = "/post/" . $post->id;

                $notificationController = new NotificationController();
                $notificationController->setNotificationType($user->id, $img, $text, $link2, $link2, "mention");

                // Variáveis para serem passadas
                $link = config('app.frontend_url') . $link2;
                $to = $user->email;

                if (config('app.send_notification_email')){
                    dispatch(new SendNotificationEmail($to, $text, $text, $link));
                }
            }

        }, $text);
    }


    public function verifyUserNameAndSendNotificationComment($text, $link){
        $padrao_tag_user = '/(@[^\s]+)/';
        $padrao_tag_user = '/(@[a-zA-Z0-9_]+)/';

        return preg_replace_callback($padrao_tag_user, function ($match) use ($link) {
            $notificationController = new NotificationController();
            $username = substr($match[0], 1); // Remove o "@" do início do username

            $user_controller = app(UserController::class);
            $user = $user_controller->getUserByUserName($username);
            if($user){
                $img = auth()->user()->img_account ? auth()->user()->img_account : '../img/img-account.png';
                $text = auth()->user()->name . " marcou você em um comentário";

                $notificationController = new NotificationController();
                $notificationController->setNotificationType($user->id, $img, $text, $link, $link, "mention");

                // Variáveis para serem passadas
                $link = config('app.frontend_url') . $link;
                $to = $user->email;

                if (config('app.send_notification_email')){
                    dispatch(new SendNotificationEmail($to, $text, $text, $link));
                }
            }

        }, $text);
    }
}
