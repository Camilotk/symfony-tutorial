### Ferramenta make e o primeiro Controller
1. O Symfony é modular e minimalista isso significa que ele vem com quase nada e que precisamos baixar e instalar os pacotes que o framework disponibiliza conforme à necessidade - isso faz parte de sua filosofia que visa ser leve -, a primeira ferramenta que precisamos instalar é a make ela será responsável por gerar a maior parte do código repetitivo para nós, para isso usaremos o composer:
```composer require`make```
2. Antes de conseguirmos criar nosso primeiro controller é necessário instalar o pacote annotations do Symfony que irá adicionar anotações como usamos em Java só que no PHP, para isso use o composer:
```composer require doctrine/annotations ```
3.  Após o make e módulo annotations ser instalado podemos usá-lo para gerar nosso primeiro controlador, para isso basta usar o comando no terminal: 
```php bin/console make:controller MainController```
E isso irá gerar o arquivo **src/Controller/MainController.php** com o seguinte conteúdo:
```php
<?php  
  
namespace App\Controller;  
  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;  
use Symfony\Component\Routing\Annotation\Route;  
  
class MainController extends AbstractController  
{
    /**  
     * @Route("/main", name="main")  
    */  
    public function index()  
    {
        return $this->json([  
           'message' => 'Welcome to your new controller!',  
          'path' => 'src/Controller/MainController.php',  
        ]);  
    }  
} 
```
