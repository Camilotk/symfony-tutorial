# Symfony
![enter image description here](https://symfony.com/images/opengraph/symfony.png)

### O que é o Framework Symfony?
Symfony é um framework - conjunto de bibliotecas e ferramentas - em PHP para a criação de aplicações de alta performance e de fácil manutenção. É altamente inspirado pelo projeto Spring da comunidade Java e nasceu inicialmente direcionado à produzir sistemas de qualidade para o mundo enterprise em PHP oferecendo soluções modulares com o máximo de reaproveitamento de código.

### Popularidade e Uso

O Symfony é um framework modular, voltado ao público enterprise e muito eficiente para a criação de microserviços. Todas essas partes de sua natureza combianda torna muito dificil estimar de forma quantitativa quantas empresas usam Symfony, uma vez em que muitos projetos utilizam apenas algumas partes ou serviços e as companhias do ramo de software enterprise não costumam divulgar o que usam para construir seus produtos.

Porém é facil de dizer que Symfony é um dos frameworks php mais populares devido ao fato da W3CTech medir o Symfony como o terceiro framework mais usado na internet, além disso foi o framework que [mais recebeu contribuições em 2019](https://symfony.com/blog/symfony-was-the-backend-framework-with-the-most-contributors-in-2019).

### Empresas que usam Symfony

#### Spotify
Segundo o site [EtonDigital](https://www.etondigital.com/popular-symfony-projects/) o Spotify usa o Symfony para construir o backend do site e isso foi confirmado por o ex-engenheiro [Mathias Petter Johansen](https://www.quora.com/On-what-language-is-Spotify-built) (porém, ele deixa claro que o Symfony não é usado na aplicação principal/player que tem o backend escrito em Clojure e Java).

### Dailymotion
O Dailymotion é completamente construído usando Symfony. Isso inclusive faz parte dos [estudos de caso disponíveis](https://symfony.com/blog/dailymotion-powered-by-symfony) no site do framework. Segundo o Rank Global da Alexa o site é o #207 mais visitado no mundo e o quarto maior volume de mídias da internet.

### ( ͡° ͜ʖ ͡°)
Ainda segundo o site  [EtonDigital](https://www.etondigital.com/popular-symfony-projects/) e confirmado no Quora e no Fórum Laracasts por funcionários da empresa o **PornHub** é construído com Symfony e o que levou a empresa a migrar o código PHP para Symfony foi justamente o grande número de requisições por dia que exigiram uma arquitetura de sistemas mais robusta para aguentar o tráfego na casa dos bilhões de requisições.

## Instalação

### Requisitos Mínimos
 -   Ter o PHP 7.2.5 or maior instalado e as seguintes extensões instaladas e habilitadas no arquivo php.ini: [Ctype](https://www.php.net/book.ctype), [iconv](https://www.php.net/book.iconv), [JSON](https://www.php.net/book.json), [PCRE](https://www.php.net/book.pcre), [Session](https://www.php.net/book.session), [SimpleXML](https://www.php.net/book.simplexml), and [Tokenizer](https://www.php.net/book.tokenizer);
 - Ter o Apache e um banco de dados devidamente instalados e configurados;
-   Ter o [Composer](https://getcomposer.org/download/), o package manager de php instalado e configurado nas variáveis de ambiente do sistema;
-   Instalar a ferramenta [Symfony](https://symfony.com/download), que adiciona diversas ferramentas para desenvolvimento com Symfony.

Caso o desenvolvedor tenha dúvidas se seu ambiente já atende a todos esses requisitos basta usar o seguinte comando após instalar a ferramenta [Symfony](https://symfony.com/download):
```bash 
$ symfony check:requirements
```
### Iniciando um novo projeto no Symfony
1. Navegue no terminal até a pasta do Apache 
``` bash 
$ cd /etc/var/www/ 
```
2. Use a ferramenta de CLI do Symfony para criar um novo projeto:
```bash
$ symfony new <nome_do_projeto>
```
3. Acesse a URL http://localhost/nome_do_projeto/public/ e caso veja a página inicial do Symfony: _parabéns seu projeto foi iniciado e está funcionando_!
4. Agora é necessário importar/abrir o código que foi gerado dentro da pasta que contêm o seu projeto e como somos todos grandinhos e escolhemos nossas ferramentas deixo isso com você.
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
### Rotas
Existem quatro formas de trabalhar com rotas no Symfony e fica à decisão do programador qual escolher:
1. **Annotations**:  Similar ao Spring Boot/.NET, o roteamento é feito através de uma anotação sobre o método/classe. Como podemos ver no código gerado pelo comando make a classe já veio anotada com a rota que chama o método index() e seu nome. Anotações é o meio padrão de trabalho do Symfony, essa pode ser uma opção bem popular para desenvolvedores que venham desses frameworks, além de adaptar-se melhor ao restante do Workflow do projeto;
2. **yaml**: Arquivos YAML são arquivos chave-valor assim como o JSON, esse tipo de arquivo é muito utilizado na configuração do Symfony, umas das configurações disponíveis é o arquivo routes.yaml onde podem ser definidas todas as rotas da aplicação, por padrão, esse arquivo vem inteiramente comentado e caso deseje usar YAML para configurar as rotas é só apagar as annotations da classe gerada, descomentar o arquivo route.yaml e preencher o arquivo com o nome da rota como chave e um array - que YAML é declarado por identação - com dois elementos chave-valor o index com o caminho de valor e path que diz qual classe e método será chamado:
```yaml
main:  
    path: /main  
    controller: App\Controller\MainController::index
```
3. **XML**: Similar à outros frameworks enterprise como JSF, para usar basta renomear o arquivo routes.yaml para routes.xml e configurar as chaves e valores com a mesma estrutura esperada no YAML, tendo path e controller dentro do nome da rota. Essa pode ser uma opção interessante ao público enterprise que está migrando de JSF/.NET ou tenham ferramentas que integram melhor com XML como o Eclipse.
```xml
<!-- config/routes.xml -->
<?xml version="1.0" encoding="UTF-8" ?>
<routes xmlns="http://symfony.com/schema/routing"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/routing
 https://symfony.com/schema/routing/routing-1.0.xsd">
 
    <route id="main" path="/main"
           controller="App\Controller\MainController::index"/>
           
</routes>
```
4. **PHP**: Similar a outros frameworks PHP populares como Codeigniter e Laravel também é possível definir rotas utilizando PHP. Para isso basta renomear o arquivo routes.yaml para routes.php e utilizar um código similar a este:
```php
use App\Controller\BlogController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('main', '/main')
        ->controller([MainController::class, 'index']);
};
``` 
Após configurar as rotas da forma que você achar melhor basta acessar o link http://localhost/sftutorial/public/index.php/main e ver o retorno do método na tela.

**Obs**: É necessário usar /index.php/main pois o Apache precisará pegar as rotas do arquivo index.php, para ter urls bacanas é necessário configurar o Virtua Hosts no Apache, aqui tem alguns tutoriais de como fazer isso no [Windows](https://www.raphaelfiga.com/desenvolvimento/instalando-configurando-virtualhost-apache-windows/), [Ubuntu](https://www.digitalocean.com/community/tutorials/como-configurar-apache-virtual-hosts-no-ubuntu-14-04-lts-pt) ou no [XAMPP](https://blog.mxcursos.com/criar-virtual-host-com-xampp/).  *Lembre-se* que não basta apontar para a pasta do projeto tem que apontar em /public/index.php para funcionar. Caso não queira fazer isso tudo bem bata continuar usando  [http://localhost/\<nome do projeto\>/public/index.php/<u>\<rota\></u>](#) que está tudo bem.

### Recebendo valores através das rotas
Para ilustar como poderiamos receber um slug, id ou nome pela URL vamos criar um novo método chamado custom e anotá-lo conforme. Note que no final da rota adicionamos "{name?}" isso é porque o valor entre chaves vai guardar o que foi passado aqui como valor da propriedade 'name' e vamos colocar '?' para indicar que esse valor é opcional e não irá gerar erro caso falte. Esse método recebe um objeto Request que contêm todas as informações vindas da requisição do usuário e retorna um objeto Response que contêm um HTML que será renderizado no navegador do usuário.
```php
/**  
 * @Route("/custom/{name?}", name="custom")  
 */
 public function custom(Request $request)  
{  
  $name = $request->get('name');  
 return new Response('<h1>Olá ' . $name. '!</h1>');  
} 
```
### Views
Para renderizar as views o Symfony utiliza o template engine [Twig](https://twig.symfony.com/) que ajuda a separar a lógica da apresentação no projeto. O Twig irá renderizar o código php dentro de {{ }} para html muito similar à quando usamos <?php ?>, mas com diversas vantagens, como pré-compilação, cache e escaping. Antes de mais nada precisamos instalar o Twig no projeto, para isso usamos o composer: ```composer require symfony/twig-bundle```.

Após termos instalado o Twig devemos criar uma pasta com o nome 'templates' dentro da **raíz do nosso projeto**, essa pasta irá conter todos os arquivos de view que criarmos. Agora dentro dessa pasta vamos criar uma outra pasta chamada 'home' que vai conter todos os nossos templates relacionados com a página 'home' e dentro um arquivo chamado custom.html.twig.

Devemos refatorar nosso código custom mudando o retorno que agora não vai ser mais o retorno, mas a função render() herdada de AbstractController que recebe o nome ou caminho do arquivo que será renderizado de dentro da pasta 'templates'.  Além disso, precisamos passar a todas as variáveis que a View precisa dentro de um array em que a chave será o nome da variável na view e o valor a variável no controller.
```php
/**  
 * @Route("/custom/{name?}", name="custom")  
 */public function custom(Request $request)  
{  
  $name = $request->get('name');  
 return $this->render('home/custom.html.twig', ['name' => $name]);  
}
```
Ok, agora vamos editar nossa view para exibir os dados como antes, dentro de templates/home/custom.html.twig coloque o conteúdo:
```html 
<h1>Hello {{ name }}!</h1>
```
Agora acesse a página passando diferentes nomes:
- [http://localhost/\<nome do projeto\>/public/index.php/custom/Symfony](#)
- [http://localhost/\<nome do projeto\>/public/index.php/custom/PHP](#)
- [http://localhost/\<nome do projeto\>/public/index.php/custom/IFRS](#)

### ORM
