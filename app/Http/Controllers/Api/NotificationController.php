<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function setNotificationType($id_user, $img_notification, $text, $link1, $link2, $typeText){
        // Define se a notificação está lida e aberta
        $read = 0;
        $opened = 0;

        // Obtem o tipo de notificação
        $type = $this->getNotificationType($typeText);

        // Verifica se já existe uma notificação igual (mesmo texto, links, imagem) nos últimos 5 minutos
        $existingNotification = Notification::where('id_user', $id_user)
            ->where('img_notification', $img_notification)
            ->where('text', $text)
            ->where('link1', $link1)
            ->where('link2', $link2)
            ->where('created_at', '>=', now()->subMinutes(5)) // verifica as notificações criadas nos últimos 5 minutos
            ->first();

        // Se já existir uma notificação igual dentro de 5 minutos, não cria uma nova
        if ($existingNotification) {
            return null; // Ou você pode retornar algo como 'false' ou 'false' se preferir
        }

        // Cria a nova notificação, caso não tenha encontrado uma igual
        $notifications = Notification::create([
            'id_user' => $id_user,
            'img_notification' => $img_notification,
            'text' => $text,
            'link1' => $link1,
            'link2' => $link2,
            'opened' => 0,
            'read' => $read,
            'type' => $type,
        ]);

        return $notifications;
    }

    public function getNotificationType($typeText){
        switch ($typeText) {
            case 'comment':
                return 1;
                break;

            case 'repostPost':
                return 2;
                break;
            
            case 'chat':
                return 3;
                break;
            
            case 'likePost':
                return 4;
                break;
            
            case 'likeComment':
                return 5;
                break;
            
            case 'mention':
                return 6;
                break;

            case 'follow':
                return 7;
                break;

            case 'responseComment':
                return 7;
                break;
            
            default:
                return 0;
                break;
        }
    }
}
