Не убирал autowiring, потому что я не смог настроить проект без него. Данный код в services.yaml не работает
//App\Controller\AdminController:
//        arguments:
//            $entityManager: '@doctrine.orm.entity_manager'
//        tags: ['controller.service_arguments']
//
//    App\Controller\:
//        resource: '../src/Controller/'
//        tags: ['controller.service_arguments']


Так же не настроил docker, потому что, как мне сказал установщик, у меня не 10 винда
composer start - команда запуска проекта
