<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Contact;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function sendMessage($message)
    {
        //Parametros
        $token = '<<Copiar token otorgado en apartado "Configuracion de la API">>';
        $url = '<<Copiar URL otorgado en apartado "Configuracion de la API">>';
        $header = [
            "Authorization: Bearer " . $token,
            "Content-Type: application/json",
            "message: EVENT_RECEIVED"
        ];

        //Envio de mensajeria
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        
        if ($response === false) {
            echo "Error en la solicitud cURL: " . curl_error($curl);
        } else {
            $response_array = json_decode($response, true);
            print_r($response_array);
        }

        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
    }


    //Verificacion de webhook para recepcion de notificaciones
    public function verifyWebhook(Request $request)
    {
        try {
            $verifyToken = '<<Establecer Token para mensajeria>>';
            $query = $request->query();

            $mode = $query['hub_mode'];
            $token = $query['hub_verify_token'];
            $challenge = $query['hub_challenge'];

            if($mode && $token){
                if($mode == "subscribe" && $token == $verifyToken){
                    return response($challenge, 200)->header('Content-Type', 'text/plain');
                }
            }
            throw new Exception('Invalid request');
        } catch (Exception $e) {
            
            return response()->json([
                'success' => false,
                'data' => $e->getMessage()
            ],500);
            
        }
    }

    public function respuesta($body)
    {
        if(strpos($body,'hola') !== false)
        {
            $notificacion = 'Hola, este es un mensaje de prueba';
        }else{
            $notificacion = 'Hola, este es un mensaje de prueba v2';
        }

        return $notificacion;
    }
    
    

    //Tipos de mensajes mas usados
    //Envio de mensaje simple
    public function struct_Message($notificacion, $number_phone){
        $mensaje = [
            "messaging_product" => "whatsapp",
            'recipient_type' => "individual",
            "to" => $number_phone,
            "type" => "text",
            "text" => [
                "body" => $notificacion,
            ]
        ];
        return $mensaje;
    }

    //Envio de Mensaje con botones
    //Envio maximo de 3 botones
    public function struct_message_buttons($notificacion, $number_phone)
    {
        $mensaje = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $number_phone,
            "type" => "interactive",
            "interactive" => [
              "type" => "button",
              "body" => [
                "text" => $notificacion
              ],
              "action" => [
                "buttons" => [
                  [
                    "type" => "reply",
                    "reply" => [
                      "id" => "1",
                      "title" => "1"
                    ]
                  ],
                  [
                    "type" => "reply",
                    "reply" => [
                      "id" => "2",
                      "title" => "2"
                    ]
                  ],
                  [
                    "type" => "reply",
                    "reply" => [
                      "id" => "3",
                      "title" => "3"
                    ]
                  ],
                ]
              ]
            ]
          ];
        return $mensaje;
    }

    //Envio de mensaje de lista
    public function struct_messages_list($notificacion, $number_phone)
    {
        $mensaje = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $number_phone,
            "type" => "interactive",
            "interactive" => [
                "type" => "list",
                "body" => [
                    "text" => $notificacion
                ],
                "action" => [
                    "button" => "Opciones",
                    "sections" => [
                        [
                            "title" => "SECTION_1_TITLE",
                            "rows" => [
                                [
                                    "id" => "1",
                                    "title" => "Muy Malo 😡",
                                ],
                                [
                                    "id" => "2",
                                    "title" => "Malo 😠",
                                ],
                                [
                                    "id" => "3",
                                    "title" => "Regular 🙂",
                                ],
                                [
                                    "id" => "4",
                                    "title" => "Bueno 😊",
                                ],
                                [
                                    "id" => "5",
                                    "title" => "Excelente 😎",
                                ],
                            ]
                        ],
                    ]
                ]
            ]
        ];

        return $mensaje;
    }

    //Envio de documentos pdf
    public function struct_message_doc($link, $caption, $number_phone)
    {
        $mensaje = [
            "messaging_product" => "whatsapp",
            'recipient_type' => "individual",
            "to" => $number_phone,
            "type" => "document",
            "document" => [
                "link" => $link,
                "caption" => $caption
            ]
          ];
          return $mensaje;
    }

    //Envio de locaciones
    public function struct_message_location($number_phone, $longitude, $latitude, $name, $address)
    {
        $mensaje = [
            "messaging_product" => "whatsapp",
            "to" => $number_phone,
            "type" => "location",
            "location" => [
                "longitude" => $longitude,
                "latitude" => $latitude, 
                "name" => $name,
                "address" => $address
            ]
        ];
        return $mensaje;
    }

    public function processWebhook(Request $request)
    {
        try {
            $bodyContent = json_decode($request->getContent(), true);
            if(!empty($bodyContent['entry'][0]['changes'][0]['value']['messages'][0])){
                $messages = $bodyContent['entry'][0]['changes'][0]['value']['messages'][0];
                $number_phone = $bodyContent['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
                if ($messages['type'] == 'text') {

                    
                    //Mensajeria simple
                    
                    $text = 'Mensaje de prueba';
                    $response_message = $this->struct_Message($text, $number_phone);
                    $this->sendMessage($response_message); 
                    

                    
                    //Mensajeria por botones
                    /* $text = 'Mensaje enviado con botones';
                    $response_message = $this->struct_message_buttons($text,$number_phone);
                    $this->sendMessage($response_message);  */
                    

                    
                    //Mensajeria por listas
                    /* $text = 'Mensaje enviado con multiples opciones';
                    $response_message = $this->struct_messages_list($text,$number_phone);
                    $this->sendMessage($response_message);   */
                   

                    
                    //Mensajeria por doc
                    
                    /* $link = 'https://www.turnerlibros.com/wp-content/uploads/2021/02/ejemplo.pdf';
                    $caption = 'Archivo publico';
                    $response_message = $this->struct_message_doc($link,$caption,$number_phone);
                    $this->sendMessage($response_message);  */  
                   

                    
                    //Mensajeria por ubicacion
                    
                    /* $longitude = "-12.089618634107495";
                    $latitude = "-77.05310979379249"; 
                    $name = "Real Plaza Salaverry";
                    $address = "Salaverry";
                    $response_message = $this->struct_message_location($number_phone, $longitude, $latitude, $name, $address);
                    $this->sendMessage($response_message); */   
                   
                }
            }

            return response()->json([
                'success' => true,
                'msg' => 'Mensaje exitoso'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
            ], 500);
        }
    }
    

}
