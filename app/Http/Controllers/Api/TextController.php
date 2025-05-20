<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $textoFormatado = $this->escapeHtml($text);
    
        // Formata links como <a>
        $textoFormatado = preg_replace_callback($padraoLink, function ($matches) {
            $url = $matches[0];
            return "<a href='{$url}' target='_blank' style='word-wrap: break-word;'>{$url}</a>";
        }, $textoFormatado);
    
        // Formata menções de usuários
        $textoFormatado = preg_replace_callback($padraoTagUser, function ($matches) {
            $username = substr(trim($matches[0]), 1); // Remove o "@"

            $user_controller = new UserController();
            $user = $user_controller->getUserByUserName($username);

            if ($user) {
                return "<a href='/@{$username}' style='word-wrap: break-word;'>{$matches[0]}</a>";
            } else {
                // Se o usuário não existir, exibe apenas o texto sem formatação
                return $matches[0];
            }
            
        }, $textoFormatado);
    
        // Formata hashtags
        $textoFormatado = preg_replace_callback($padraoHashtag, function ($matches) {
            $hashtag = substr($matches[0], 1); // Remove o "#"
            return "<a href='/hashtag/{$hashtag}' style='word-wrap: break-word;'>{$matches[0]}</a>";
        }, $textoFormatado);
    
        // return $textoFormatado;
        return $this->substituirEmojis($textoFormatado);
    }

    function substituirEmojis($texto) {
        $emojis = [
            ':pacoca:' => "<img src='/img/pacoca-sem-braco.png' class='emoji' alt=':pacoca:' data-title=':pacoca:' style='height: 22px; width: 22px'>",
            ':pacoca_corpo:' => "<img src='/img/pacoca-com-braco.png' class='emoji' alt=':pacoca_corpo:' data-title=':pacoca_corpo:' style='height: 22px; width: 22px'>",
            ':pacoca_fundo:' => "<img src='/img/estante_icon_fundo.png' class='emoji' alt=':pacoca_fundo:' data-title=':pacoca_fundo:' style='height: 22px; width: 22px'>",
            ':pacoca_fundo_braco:' => "<img src='/img/pacoca-com-braco-rounded.png' class='emoji' alt=':pacoca_fundo_braco:' data-title=':pacoca_fundo_braco:' style='height: 22px; width: 22px'>",
            ':pacoca_cat:' => "<img src='/img/nyan-cat.gif' class='emoji' alt=':pacoca_cat:' data-title=':pacoca_cat:' style='height: 40px; width: 40px'>",
            ':pacoca_404:' => "<img src='/img/page-not-found.jpg' class='emoji' alt=':pacoca_404:' data-title=':pacoca_404:' style='height: 30px; width: 30px'>",
            ':pacoca_500:' => "<img src='/img/errors/pato.png' class='emoji' alt=':pacoca_500:' data-title=':pacoca_500:' style='height: 25px; width: 25px'>",
            ':bochecha:' => "<img src='/img/emoji/bochecha.png' class='emoji' alt=':bochecha:' data-title=':bochecha:' style='height: 25px; width: 25px'>",

            ':pacoca_choro:' => "<img src='/img/emoji/choro.png' class='emoji' alt=':pacoca_choro:' data-title=':pacoca_choro:' style='height: 30px; width: 30px'>",
            ':pacoca_fome:' => "<img src='/img/emoji/fome.png' class='emoji' alt=':pacoca_fome:' data-title=':pacoca_fome:' style='height: 30px; width: 30px'>",
            ':pacoca_raiva:' => "<img src='/img/emoji/raiva.png' class='emoji' alt=':pacoca_raiva:' data-title=':pacoca_raiva:' style='height: 30px; width: 30px'>",
            ':pacoca_beijo:' => "<img src='/img/emoji/beijo.png' class='emoji' alt=':pacoca_beijo:' data-title=':pacoca_beijo:' style='height: 30px; width: 30px'>",

            ':pacoca_caveira:' => "<img src='/img/emoji/caveira.png' class='emoji' alt=':pacoca_caveira:' data-title=':pacoca_caveira:' style='height: 30px; width: 30px'>",
            ':pacoca_palhaco:' => "<img src='/img/emoji/palhaco.png' class='emoji' alt=':pacoca_palhaco:' data-title=':pacoca_palhaco:' style='height: 30px; width: 30px'>",
            ':pacoca_oculos:' => "<img src='/img/emoji/oculos.png' class='emoji' alt=':pacoca_oculos:' data-title=':pacoca_oculos:' style='height: 30px; width: 30px'>",
            ':pacoca_diabinho:' => "<img src='/img/emoji/diabinho.png' class='emoji' alt=':pacoca_diabinho:' data-title=':pacoca_diabinho:' style='height: 30px; width: 30px'>",
            ':pacoca_caveira:' => "<img src='/img/emoji/caveira.png' class='emoji' alt=':pacoca_caveira:' data-title=':pacoca_caveira:' style='height: 30px; width: 30px'>",
            ':pacoca_anjo:' => "<img src='/img/emoji/anjo.png' class='emoji' alt=':pacoca_anjo:' data-title=':pacoca_anjo:' style='height: 28px; width: 35px'>",
            ':pacoca_anjo:' => "<img src='/img/emoji/anjo.png' class='emoji' alt=':pacoca_anjo:' data-title=':pacoca_anjo:' style='height: 28px; width: 35px'>",
            ':pacoca_assustado:' => "<img src='/img/emoji/assustado.png' class='emoji' alt=':pacoca_assustado:' data-title=':pacoca_assustado:' style='height: 30px;'>",
            ':pacoca_derretendo:' => "<img src='/img/emoji/derretendo.png' class='emoji' alt=':pacoca_derretendo:' data-title=':pacoca_derretendo:' style='height: 30px;'>",
        ];
        
        
        return str_replace(array_keys($emojis), array_values($emojis), $texto);
    }
    
    
    
    // Função auxiliar para escapar HTML
    function escapeHtml($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
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
