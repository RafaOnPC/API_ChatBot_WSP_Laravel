###  👉 Descripción

API Rest desarrollada en Laravel, enfocada en facilitar la creación y personalización de asistentes virtuales (chatbots) adaptados a cualquier proceso empresarial. Este proyecto base cuenta con una integración completa de todos los tipos de mensajes disponibles por la API oficial de Meta/WhatsApp. Para ello, se ha utilizado un método processWebhook(), para la gestion del envío, recepción y respuesta de mensajes de manera ágil y efectiva.

Con esta API, los desarrolladores podran construir flujos de comunicación personalizados en menor tiempo para cualquier proceso y tipo de negocio, aprovechando la versatilidad de configuracion de los tipos de mensajes de WhatsApp. Desde notificaciones automáticas y respuestas a consultas frecuentes hasta la gestión de pedidos y citas, entre otros.

### 👉 Aspectos Destacados
+ ###  Flexibilidad a cualquier tipo y proceso de negocio
La API está diseñada para adaptarse a cualquier lógica de negocio, permitiendo una personalización completa según los requisitos específicos de cada empresa.

+ ### Integración completa de Webhooks
Utilizando el método processWebhook(), se gestionan eficientemente el envío, recepción y respuesta de mensajes, asegurando una comunicación fluida entre el asistente virtual y los usuarios.

+ ### Integración sencilla
Se integra fácilmente con otros sistemas y servicios empresariales, como bases de datos, plataformas de CRM y sistemas de gestión de pedidos.

### 👉 Configuración de Webhook

1. Iniciar el servidor con el comando: *php artisan serve*
2. En el agente de ngrok aperturar puerto publico con el comando: *ngrok http http://localhost:8080*
3. Ingresar a la dirección especifica en la Web Interface encontrado en el agente de Ngrok
4. Dirigirse al panel de configuracion de API de Whatsapp para verificar y generar el webhook del asistente virtual para ello utilizar el endpoint "verify_webhook()"
5. Establecer una URL de devolucion de llamada y un token de verificación 
6. Configuracion exitosa

### 👉 Ejecución

1. *php artisan serve*
2. *ngrok http http://localhost:8080*

### 👉 Images

![Servidor_corriendo](https://github.com/RafaOnPC/API_ChatBot_WSP_Laravel/assets/128557603/e7e4c60c-3231-4515-b118-67393ceee2c2)

![Agente_ngrok](https://github.com/RafaOnPC/API_ChatBot_WSP_Laravel/assets/128557603/043a8f4e-e5a5-47a1-894c-e89833c7a4f1)

![Configuracion_Exitosa](https://github.com/RafaOnPC/API_ChatBot_WSP_Laravel/assets/128557603/9d165b2e-63ab-4cfa-857c-59837e7b5821)

![Mensajes_code](https://github.com/RafaOnPC/API_ChatBot_WSP_Laravel/assets/128557603/755c28c4-26cb-4280-93ae-1872997c33f2)

![Conversacion_ejemplo](https://github.com/RafaOnPC/API_ChatBot_WSP_Laravel/assets/128557603/a761b885-c4d4-41e1-8622-a82074c7c265)

![Lista_desplegada](https://github.com/RafaOnPC/API_ChatBot_WSP_Laravel/assets/128557603/250d3bde-54a9-4962-a436-a438e44ca70a)

![Conversacion_ejemplo2](https://github.com/RafaOnPC/API_ChatBot_WSP_Laravel/assets/128557603/b13d2d5b-b21f-4cd6-a26e-3d5a828403da)
