# Symfony
![](https://symfony.com/images/opengraph/symfony.png)

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

![Página inicial do Symfony](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/welcome.png)

4.  Agora é necessário importar/abrir o código que foi gerado dentro da pasta que contêm o seu projeto e como somos todos grandinhos e escolhemos nossas ferramentas deixo isso com você.
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

![Estrutura de pastas](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/folders.png)

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

### Criando o template da página
Digamos que quiséssemos adicionar o Bulma CSS CDN no projeto e que todas as páginas exibissem uma navbar. Para isso teríamos que criar um template que diversas páginas usariam, o que reduz drasticamente a quantidade de código que temos que escrever além de facilitar a manutenção do front-end. Dependendo a IDE que você escolheu pode ser que ela tenha criado um arquivo dentro da pasta templates chamado base.html.twig, caso não tenha crie. Iremos criar um template padrão e adicionar o link do CDN no head, o que deve ficar assim:

```php
<!DOCTYPE html>  
<html>  
<head>  
 <meta charset="UTF-8">  
 <title>{% block title %}Welcome!{% endblock %}</title>  
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">  
  {% block stylesheets %}{% endblock %}  
</head>  
<body>  
<nav class="navbar  is-link" role="navigation" aria-label="main navigation">  
 <div class="navbar-brand">  
 <a class="navbar-item" href="{{ path('main') }}">  
 <img style="max-width: 30px;" src="https://i0.wp.com/phpmagazine.net/wp-content/uploads/2018/12/symfony-logo-png-transparent.png?fit=2400%2C2410"  
  alt="Bulma: Free, open source, and modern CSS framework based on Flexbox" width="112" height="28">  
 </a>  
 <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">  
 <span aria-hidden="true"></span>  
 <span aria-hidden="true"></span>  
 <span aria-hidden="true"></span>  
 </a>  
 <div id="navbarBasicExample" class="navbar-menu">  
 <div class="navbar-start">  
 <a class="navbar-item" href="{{ path('custom', {name: 'Symfony'}) }}">  
  Greet Symfony  
 </a>  
 <a class="navbar-item" href="{{ path('custom', {name: 'PHP'}) }}">  
  Greet PHP  
 </a>  
 </div> 
 </div> 
 </div>
 </nav>  
<section class="section">  
 <div class="container">  
  {% block body %}{% endblock %}  
    </div>  
</section>  
{% block javascripts %}{% endblock %}  
</body>  
</html>
```
Você deve ter notado os blocos {% %}, então, eles são as partes dinâmicas do nosso template, onde o conteúdo de cada página será inserido. No momento o que nos importa é o **body**.  Para dizermos qual template nossa página irá usar passamos a função **extends(** *String arquivo_template* **)** e em seguida as tags block com o conteúdo que queremos inserir em cada bloco.
```php
{% extends('base.html.twig') %}  
{% block title %} Meu primeiro Twig! {% endblock %}  
{% block body %} <h1 class="title">Hello {{ name }}!</h1> {% endblock %}
```
Para que possamos entender a diferença entre a navegação de páginas vamos alterar nosso método index() na classe **MainController** para: 
```php
/**  
 * @Route("/main", name="main")  
 */public function index()  
{  
  return $this->render('home/index.html.twig');  
}
```
E dentro de templates/home/ vamos criar um novo arquivo chamado de index.html.twig com o seguinte conteúdo:
```php
{% extends('base.html.twig') %}  
{% block title %} Home {% endblock %}  
{% block body %} <h1>Home</h1> {% endblock %}
```
O resultado será isso:
**Home Page**:

![Página Home](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/home-page.png)

**Greet Symfonry**:

![Página Greet Symfony](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/symfony-page.png)

**Greet PHP**:

![Página Greet PHP](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/php-page.png)

Eu sei, isso deve estar parecendo muita coisa. E é. Mas vá com calma, aproveite para analisar o código do template e ver o que está acontecendo apesar de parecer dificil não é. Aproveite para tentar fazer alterações e ver o que acontece, por ex: Criar um link para Greet \<seu_nome\> certamente ficará mais claro como as coisas funcionam.
### ORM
O Symfony usa por padrão o **Doctrine** - que é um projeto separado -  como ORM padrão. Como os demais componentes temos que primeiro instalar o ORM para que seja possível utilizá-lo. Para isso utilizaremos o composer:
```composer require`orm```
Após instalado irá aparecer a seguinte mensagem:
```
 * Modify your DATABASE_URL config in .env
 * Configure the driver (mysql) and server_version (5.7) in config/packages/doctrine.yaml 
 ```
Esse será nosso próximo passo. Se  abrirmos a pasta config/packages vamos notar que teremos 2 arquivos novos **doctrine.yaml** e **doctrine_migrations.yaml**. Da mesma forma verá que no arquivo .env será inserido a linha:
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
Que nada mais é que nossa <u>connection string</u> com o Banco de Dados. Acima haverá um comentário explicando como configurar a string para outros Bancos de Dados além do MySQL. Para que possamos conectar nosso projeto com o banco precisaremos substituir os seguintes valores na URL:
 * db_user com o nome do usuário MySQL
 * db_password com a senha desse usuário
 * 127.0.0.1:3306 com endereço e porta que o Banco está rodando, para localhost não precisa mudar nada aqui.
 * db_name pelo nome do banco que será conectado

Além de instalar o ORM e adicionar as configurações para nós, quando instalamos o Doctrine também instalamos diversos comandos CLI que vão nos ajudar a administrar o Banco de Dados, em seu terminal, digite:
 ```  php bin/console doctrine:database:create```
 Vamos notar que nosso banco de dados ainda está vazio, no Doctrine cada tabela será um objeto do nosso sistema, conhecido como entidade, para criarmos nossa primeira entidade devemos usar o comando:
  ```  php bin/console make:entity```
  Após entrarmos com esse comando o terminal irá fazer algumas perguntas sobre a entidade que vamos criar e vamos entrar com as seguintes respostas:
 -  Class name of the entity to create or update (e.g. FierceElephant): 
 \> **Post**
 -  New property name (press <return> to stop adding fields):
 \> **title**
 -  Field type (enter ? to see all types) [string]:
 \> [Enter]
 - Field length [255]:
 \> [Enter]
 - Can this field be null in the database (nullable) (yes/no) [no]:
  \> [Enter]
 -  Add another property? Enter the property name (or press <return> to stop adding fields):
 \> [Enter]

Pronto! Temos nossa primeira entidade que será Post com o atributo do tipo String title. Dentro da pasta src/Entity encontraremos Post.php que é nossa entidade. Você poderá notar que a Classe está cheia de annotations, elas servem para configurar como esses dados serão transformados em tabela no Banco de Dados (para quem já usou Java é assim que o JPA/Hibernate trabalham também).  Para fazermos nossa primeira tabela devemos novamente usar o console do Symfony com o comando:
``` php bin/console doctrine:schema:update --force ```
Peraí, como assim --force? Sim, caso tentássemos executar esse comando sem a flag --force o Doctrine nos avisaria que em produção deveriamos usar migrations (que não irei tratar aqui, mas a documentação do framework é bem completa sobre isso) e que apenas deveriamos usar schema:update caso estivermos em ambiente de desenvolvimento e cientes do que fazemos (nosso caso) e que caso estejamos cientes, devemos usar --force.

![tabela criada](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/post-criado.png)

Legal, agora temos a tabela post como podemos ver no print a abaixo:
Mas como posso criar Posts? Bem, para continuar nossa explicação primeiro precisaremos criar um controller para Post, para isso usamos o comando make:
``` php bin/console make:controller PostController ```
Em src/Controller/PostController.php vamos criar um novo método:
```php
/**  
 * @Route("/post/create", name="post.create")  
 * @param Request $request  
  * @return Response  
 */public function create(Request $request)  
{  
  // cria um novo post com titulo  
  $post = new Post();  
  $post->setTitle('Post Title');  
  
  // entity manager  
  $em = $this->getDoctrine()->getManager();  
  $em->persist($post); // salva o Objeto Post na tabela post  
  $em->flush();  
  
  // return a response  
  return new Response('O seu post foi criado.');  
}
```
Todas as informações no nosso BD serão objetos, por isso, devemos trabalhar instanciando as entidades e colocando em seus atributos as informações que queremos salvar, assim como fizemos com o objeto <u>Post</u>. Porém, nossas entidades não tem nenhum método que faça a persistência em si, para isso utilizamos o objeto EntityManager do Symfony, não devemos instancia-lo diretamente, mas utilizar o método <u>getDoctrine()->getManager()</u> que nosso controlador herda de AbstractController que é um Factory para esse objeto. Tendo esse objeto instanciado então podemos usar a função <u>persist( _objeto_ )</u> do EntityManage para persistir os dados do nosso objeto e <u>flush()</u> para encerrar/fechar a conexão com o BD. **obs:** Caso a conexão não ser fechada as Queries não serão executadas e por tanto não haverá os dados no BD. E ao acessar <u>http://localhost/sftutorial/public/index.php/post/create</u> veremos ``` O seu post foi criado. ``` e se tentarmos consultar nosso BD veremos que nossa informação estará lá:

![consulta a tabela posts](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/consulta-sql.png)

Agora que inserimos nosso primeiro Post como fazemos para buscar a informação no Banco? Para isso vamos alterar o método <u>index()</u> automaticamente criado pelo CLI para listar todos os posts alterando-o para:
```php
/**  
 * @Route("/post", name="post")  
 * @param PostRepository $repository  
  * @return Response  
 */public function index(PostRepository $repository)  
{  
  $posts = $repository->findAll();  
  return $this->render('post/index.html.twig', [  
  'controller_name' => 'PostController',  
  'posts' => $posts  
  ]);  
}
```
Como podemos notar usamos um objeto PostRepository, esse objeto é criado junto com a Entidade Post e fica em src/Repository/PostRepository.php, essa classe possui vários métodos que podemos usar para conseguir buscar nossas informações no BD como:

 - findAll(): Que retorna um array com todos os dados da tabela/entidade.
 - find(): Que retorna um objeto pelo id.
 - findBy(): Que retorna um array  de objetos selecionados por determinada característica.
 - findOneBy(): Que retorna um objeto selecionado por determinada característica.
Caso você esteja usando uma IDE que tenha um autocomplete minimamente decente ele irá mostrar esses e outros métodos do repositório com suas devidas assinaturas <strike>caso não estja, devia estar</strike>. Como vimos, depois de pegar todos os nossos posts estamos passando ele para a view index.html.twig dentro da pasta templates/posts/, essa view é automaticamente criada pelo comando make quando criamos um controller <u>após</u> termos instalado o twig no projeto, vamos alterar essa view para:
```html
{% extends 'base.html.twig' %}  
  
{% block title %}Listagem de posts{% endblock %}  
  
{% block body %}  
    <h1 class="title">Lista de Posts</h1>  
	 <table class="table">  
		<thead> 
		 <tr> 
			 <th><abbr title="Identification">ID</abbr></th>  
			<th>Title</th>  
		 </tr>
		</thead> 
		<tfoot> 
		<tr> 
			<th><abbr title="Identification">ID</abbr></th>  
			<th>Title</th>  
		 </tr> 
		 </tfoot> 
		 <tbody>  
		 {% for post in posts %}  
	          <tr>  
			 <td>{{ post.id }}</td>  
			 <td>{{ post.title }}</td>  
		 </tr>  
		 {% endfor %}  
	        </tbody>  
 </table>  
{% endblock %}
```
Para repertimos a criação de posts podemos dar refresh na página /post/create que chama o método <u>create()</u> do nosso PostController e então acessarmos http://localhost/sftutorial/public/index.php/post onde veremos: 

![listagem de posts](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/tabela-posts.png)
