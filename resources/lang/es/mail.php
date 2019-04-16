<?php

return [
	
	/*
	|--------------------------------------------------------------------------
	| Emails Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the Mail notifications.
	|
	*/
	
	// mail_footer
	'mail_footer_content'            => ':appName, vende y compra cerca de ti. Simple, rápido y eficiente.',
	
	
	// email_verification
	'email_verification_title'       => '[:appName] Por favor verifique su dirección de correo electrónico.',
	'email_verification_action'      => 'Confirme su dirección de correo electrónico',
	'email_verification_content_1'   => 'Hola :userName !',
	'email_verification_content_2'   => 'Haga clic en el botón de abajo para verificar su dirección de correo electrónico.',
	'email_verification_content_3'   => '¿El botón no funciona? Pega el siguiente enlace en tu navegador:<br><a href=":verificationLink">:verificationLink</a>.',
	'email_verification_content_4'   => '<br><br>Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	'email_verification_content_5'   => '<br><br>Saludos cordiales,<br>El equipo :appName',
	
	
	// post_activated
	'post_activated_title'             => 'Tu anuncio ha sido activado',
	'post_activated_content_1'         => 'Hola, <br><br>Tu anuncio <a href=":postUrl">:title</a> ha sido activado.',
	'post_activated_content_2'         => '<br>Pronto será examinado por uno de nuestros administradores para su publicación.',
	'post_activated_content_3'         => '<br><br>Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	'post_activated_content_4'         => '<br><br>Saludos cordiales,<br>El equipo :appName',
	
	// post_reviewed
	'post_reviewed_title'              => 'Tu anuncio ya está activado',
	'post_reviewed_content_1'          => 'Hola, <br><br>Tu anuncio <a href=":postUrl">:title</a> ha sido activado.',
	'post_reviewed_content_2'          => '<br><br>Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	'post_reviewed_content_3'          => '<br><br>Saludos cordiales,<br>El equipo :appName',
	
	
	// post_deleted
	'post_deleted_title'               => 'Tu anuncio ha sido eliminado',
	'post_deleted_content_1'           => 'Hola,<br><br>Tu anuncio ":title" ha sido eliminado de <a href=":appUrl">:appName</a> hoy :now.',
	'post_deleted_content_2'           => '<br><br>Gracias por su confianza y hasta pronto,',
	'post_deleted_content_3'           => '<br><br>El equipo :appName',
	'post_deleted_content_4'           => '<br><br><br>PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// post_seller_contacted
	'post_seller_contacted_title'      => 'Tu anuncio ":title" en :appName',
	'post_seller_contacted_content_1'  => '<strong>Información de contacto:</strong><br>Nombre: :name<br>Correo electrónico: :email<br>Número de teléfono: :phone<br><br>Este correo electrónico se le envió acerca del anuncio ":title" que usted tiene en <a href=":appUrl">:appName</a> : <a href=":postUrl">:postUrl</a>',
	'post_seller_contacted_content_2'  => '<br><br>PS: La persona que contactó con usted no sabe su correo electrónico ya que no responderá.',
	'post_seller_contacted_content_3'  => '<br><br>Recuerde verificar siempre los detalles de la persona de contacto (nombre, dirección, ...) para asegurarse de tener un contacto en caso de disputa. En general, elija la entrega del artículo en la mano. <br> <br> ¡Tenga cuidado con las ofertas atractivas! Tenga cuidado con las solicitudes del exterior cuando solo tiene un correo electrónico de contacto. La transferencia bancaria por Western Union o MoneyGram propuesta puede ser artificial.',
	'post_seller_contacted_content_4'  => '<br><br>Gracias por su confianza y hasta pronto,',
	'post_seller_contacted_content_5'  => '<br><br>El equipo :appName',
	'post_seller_contacted_content_6'  => '<br><br><br>PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// user_deleted
	'user_deleted_title'             => 'Tu cuenta ha sido eliminada de :appName',
	'user_deleted_content_1'         => 'Hola,<br><br>Tu cuenta ha sido eliminada de <a href=":appUrl">:appName</a> hoy :now.',
	'user_deleted_content_2'         => '<br><br>Gracias por su confianza y hasta pronto,',
	'user_deleted_content_3'         => '<br><br>El equipo :appName',
	'user_deleted_content_4'         => '<br><br><br>PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// user_activated
	'user_activated_title'           => 'Bienvenido a :appName !',
	'user_activated_content_1'       => 'Bienvenido a :appName :userName !',
	'user_activated_content_2'       => '<br>Tu cuenta ha sido activada.',
	'user_activated_content_3'       => '<br><br><strong>Nota: El equipo de :appName te recomienda:</strong><br><br>1 - Siempre tenga cuidado con los anunciantes que se niegan a hacerle ver lo bueno que se ofrece para la venta o alquiler,<br>2 - Nunca envíe dinero por Western Union u otro mandato internacional.<br><br>Si tiene alguna duda sobre la seriedad de un anunciante, contáctenos inmediatamente. Luego podemos neutralizar lo más rápido posible y evitar que alguien menos informado se convierta en la víctima.',
	'user_activated_content_4'       => '<br><br>Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	'user_activated_content_5'       => '<br><br>Saludos cordiales,<br>El equipo :appName',
	
	
	// reset_password
	'reset_password_title'           => 'Restablecer su contraseña',
	'reset_password_action'          => 'Restablecer contraseña',
	'reset_password_content_1'       => '¿Olvidaste tu contraseña?',
	'reset_password_content_2'       => 'Vamos a darte una nueva.',
	'reset_password_content_3'       => 'Si no solicitó un restablecimiento de contraseña, no se requiere ninguna acción adicional.',
	'reset_password_content_4'       => '<br><br>Saludos cordiales,<br>:appName',
	'reset_password_content_5'       => '<br><br>---<br>Si tiene problemas al hacer clic en el botón "Restablecer contraseña", copie y pegue la URL que aparece a continuación en su navegador web:<br> :link',
	
	
	// contact_form
	'contact_form_title'             => 'Nuevo mensaje de :appName',
	'contact_form_content'           => ':appName - Nuevo mensaje',
	
	
	// post_report_sent
	'post_report_sent_title'           => 'Nuevo informe de abuso',
	'post_report_sent_content'         => 'Nuevo informe de abuso - :appName/:countryCode',
	'Post URL'                         => 'Enlace del anuncio',
	
	
	// post_archived
	'post_archived_title'              => 'Tu anuncio ha sido archivado',
	'post_archived_content_1'          => 'Hola,<br><br>Tu anuncio ":title" ha sido archivado en :appName hoy :now.',
	'post_archived_content_2'          => '<br><br>Puede volver a publicar el anuncio, haciendo clic aquí: <a href=":repostLink">:repostLink</a>',
	'post_archived_content_3'          => '<br><br>Si no haces nada, tu anuncio se eliminará permanentemente el :dateDel.',
	'post_archived_content_4'          => '<br><br>Gracias por su confianza y hasta pronto,',
	'post_archived_content_5'          => '<br><br>El equipo :appName<br>:appName',
	'post_archived_content_6'          => '<br><br><br>PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// post_will_be_deleted
	'post_will_be_deleted_title'       => 'Su anuncio será eliminado en :days dias',
	'post_will_be_deleted_content_1'   => 'Hola,<br><br>Tu anuncio ":title" será eliminado de :appName en :days dias.',
	'post_will_be_deleted_content_2'   => '<br><br>Puede volver a publicar el anuncio, haciendo clic aquí: <a href=":repostLink">:repostLink</a>',
	'post_will_be_deleted_content_3'   => '<br><br>Si no haces nada, tu anuncio se eliminará permanentemente el :dateDel.',
	'post_will_be_deleted_content_4'   => '<br><br>Gracias por su confianza y hasta pronto,',
	'post_will_be_deleted_content_5'   => '<br><br>El equipo :appName<br>:appName',
	'post_will_be_deleted_content_6'   => '<br><br><br>PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// post_notification
	'post_notification_title'          => 'Un nuevo anuncio ha sido publicado',
	'post_notification_content_1'      => 'Hola Admin,<br><br>El usuario :advertiserName acaba de publicar un anuncio nuevo.',
	'post_notification_content_2'      => '<br>El título del anuncio: :title<br>Publicado: :now a :time',
	'post_notification_content_3'      => '<br><br>Saludos cordiales,<br>El equipo :appName',
	
	
	// user_notification
	'user_notification_title'        => 'Registro de nuevo usuario',
	'user_notification_content_1'    => 'Hola Admin,<br><br>:name acaba de registrarse.',
	'user_notification_content_2'    => '<br>Registrado: :now a :time<br>Correo electrónico: <a href="mailto::email">:email</a>',
	'user_notification_content_3'    => '<br><br>Saludos cordiales,<br>El equipo :appName',
	
	
	// payment_sent
	'payment_sent_title'             => 'Gracias por su pago!',
	'payment_sent_content_1'         => 'Hola,<br><br>Hemos recibido el pago por el anuncio ":title".',
	'payment_sent_content_2'         => '<br><h1>Gracias!</h1>',
	'payment_sent_content_3'         => '<br>Saludos cordiales,<br>El equipo :appName',
	
	
	// payment_notification
	'payment_notification_title'     => 'Se ha hecho un nuevo pago',
	'payment_notification_content_1' => 'Hola Admin,<br><br>El usuario :advertiserName acaba de pagar un paquete por el anuncio ":title".',
	'payment_notification_content_2' => '<br><br><strong>LOS DETALLES DEL PAGO</strong><br><strong>Motivo del pago:</strong> Anuncio #:adId - :packageName<br><strong>Cantidad:</strong> :amount :currency<br><strong>Método de pago:</strong> :paymentMethodName',
	'payment_notification_content_3' => '<br><br>Saludos cordiales,<br>El equipo :appName',
	
	
	// reply_form
	'reply_form_title'               => ':subject',
	'reply_form_content_1'           => 'Hola,<br><br><strong>Has recibido una respuesta de: :senderName. Vea el mensaje a continuación:</strong><br><br>',
	'reply_form_content_2'           => '<br><br>Saludos cordiales,<br>El equipo :appName',


];
