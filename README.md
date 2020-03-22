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

```twig
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
```twig
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
```twig
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
Certo, agora queremos exibir uma página com cada post, como fariamos isso? Vamos lá, primeiro devemos voltar à PostController e adicionar o método show que irá exibir cada página trazendo a informação do post:
```php
/**  
 * @Route("/post/show/{id}", name="post.show")  
 * @param Request $request  
  * @return Response  
 */
 public function show(PostRepository $repository, $id)  
 {  
  $post = $repository->find($id);  
  return $this->render('post/show.html.twig', [ 'post' => $post]);  
 }
```
E então devemos alterar o conteúdo do for em posts/index.html.twig para que tenha os links individuais de cada post:
```twig
{% for post in posts %}  
<tr>  
 <td>{{ post.id }}</td>  
 <td> <a href="{{ path('post.show', {id: post.id}) }}">  
  {{ post.title }}  
            </a>  
 </td> 
</tr>
{% endfor %}
 ```
 E então criarmos a página show.html.twig que irá mostrar o ID e o título do post:
 ```twig
 {% extends 'base.html.twig' %}  
  
{% block title %} {{ post.title }}{% endblock %}  
  
{% block body %}  
    <h1 class="title">ID: {{ post.id }} Titulo: {{ post.title }}</h1>  
{% endblock %}
```
Se tudo der certo a página de listagem de posts deve ficar assim:
![listagem com links](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/listagem-com-links.png)
e ao clicar no post de ID 1 você verá:
![post](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/post.png)
Agora vamos criar uma função para remover um post, para isso vamos voltar novamente ao controller e criar uma função chamada <u>remove()</u>:
```php
```/**  
 * @Route("/post/delete/{id}", name="post.delete")  
 * @param Request $request  
  * @return Response  
 */
public function remove(PostRepository $repository, $id)  
{  
  $post = $repository->find($id);  
  
  // entity manager  
  $em = $this->getDoctrine()->getManager();  
  $em->remove($post); // remove
  $em->flush();  
  
 return $this->redirect($this->generateUrl('post'));  
}
```
Agora precisamos adicionar essa ação na nossa listagem para que o usuário possa deletar o post que ele quiser, para isso temos que alterar nossa tabela em post/index.html.twig para:
```twig
<table class="table is-fullwidth is-hoverable">  
 <thead> <tr> <th><abbr title="Identification">ID</abbr></th>  
 <th>Title</th>  
 <th>Actions</th>  
 </tr> </thead> <tfoot> <tr> <th><abbr title="Identification">ID</abbr></th>  
 <th>Title</th>  
 <th>Actions</th>  
 </tr> </tfoot> <tbody>  {% for post in posts %}  
        <tr>  
 <td>{{ post.id }}</td>  
 <td> <a href="{{ path('post.show', {id: post.id}) }}">  
  {{ post.title }}  
                <a href="{{ path('post.delete', {id: post.id}) }}" class="has-text-danger">Delete</a>
 </td> </tr>  {% endfor %}  
    </tbody>  
</table>
```
Se tudo der certo a tabela deve-se parecer com essa:
![listagem com delete](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/delete.png)

### Flash Message

Você deve ter notado que quando clicamos em um link 'delete' a página simplemente dá refresh sem avisar nada ao usuário. Para adicionarmos uma mensagem temporária de que o post foi deletado com sucesso basta adicionarmos essa linha <u>antes do retorno</u> de remove() no PostController:
```php
$this->addFlash('success', 'O Post foi deletado');
``` 
E agora acima da nossa tabela de posts vamos adicionar:
```twig
{% for message in app.flashes('success') %}  
 <div class="message is-success">  
	 <div class="message-body">  
		  {{ message }}  
	 </div>  
 </div>
{% endfor %}
```
Que irá buscar na memória flash pelas mensagens com o nome 'success' e exibir acima da tabela sempre que alguém excluir um item e mostrar temporariamente para o usuário. Caso quisessemos fazer o mesmo com erro bastaria fazer outro for para erros e nele mudar todos os 'success' por 'danger'.
### Formulários
O Symfony tem várias formas de fazer formulários, vamos utilizar a mais simples: formulários auto-gerados a partir de uma entidade. Para isso precisamos primeiro instalar o criador de formulários:
``` composer require form validator  ```
Depois de ter esses pacotes instalados no projeto basta darmos o comando:
``` php bin/console make:form ```
E ele novamente irá fazer algumas perguntas:

 - The name of the form class (e.g. FierceElephantType):
 \> **PostType**
 -  The name of Entity or fully qualified model class name that the new form will be bound to (empty for none):
\> **Post**

Esse comando irá criar uma nova classe em src/Form/PostType.php, esse formulário possui dois métodos <U>buildForm()</u> que é reponsavel por construir e renderizar os formulários com os elementos e propriedades corretos  e configureOptions que é utilizado para mudar configurações do formulário e no momento apenas possui um $resolver com o método setDefaults() que utiliza todas as configurações padrão exceto por data_class que diz qual entidade está ligada ao formulário.

Agora precisamos mudar nossa função create() em PostController para ao invés de sempre criar um Post com o mesmo título e persistir mostar um formulário onde vamos preencher o título e então gravar no Banco de Dados. Para isso alteramos a função create para: 
```php
/**  
 * @Route("/post/create", name="post.create")  
 * @param Request $request  
  * @return Response  
 */
public function create(Request $request)  
{  
  // cria um novo post com titulo  
  $post = new Post();  
  
  // cria um novo formulário usando PostType de modelo que após preenchido  
 // passa as informações para o objeto $post  $form = 
  $this->createForm(PostType::class, $post);  
  
 // return a response  
  return $this->render('post/create.html.twig', [  
  'form' => $form->createView()  
 ]);  
}
```
Agora precisamos criar uma view que irá renderizar esse formulário. Para isso precisamos criar uma nova view em posts/ chamada create.html.twig conforme mandamos renderizar que será assim: 
```twig
{% extends 'base.html.twig' %}  
  
{% block title %} Novo Post {% endblock %}  
  
{% block body %}  
    {{ form(form) }}  
{% endblock %}
```
Legal, agora se acesarmos http://localhost/sftutorial/public/index.php/post/create veremos que criou o formulário mas nem adicionou o botão de enviar ou as classes corretas. Para adicionar o botao de enviar vamos voltar em PostType e alterar o método <u>buildForm</u> para: 
```php
public function buildForm(FormBuilderInterface $builder, array $options)  
{  
  $builder  
  ->add('title')  
  ->add('save', SubmitType::class)  
  ;  
}
```
Existem inúmeros componentes que podem ser adicionados aos formulários. Para saber mais sobre cada um basta consultar a documentação nesse aspecto. Legal agora nosso formulário deve se parecer com isso:

![formulario novo post](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/fomulario-starter.png)
Certo, agora falta adicionar as classes do Bulma CSS para que fique estiloso para isso vamos adicionar um terceiro parametro em cada add com as propriedades que queremos que os elementos possuam:
```php
public function buildForm(FormBuilderInterface $builder, array $options)  
{  
  $builder  
  ->add('title', null, [   
 'attr' => [  
  'class' => 'input'  
  ],  
  'row_attr' => [  
  'class' => 'field'  
  ]  
 ]) ->add('save', SubmitType::class, [  
  'attr' => [  
  'class' => 'button is-primary'  
  ]  
 ])  ;  
}
```
E após essa mudança se atualizarmos a página que tem o formulário para a criação de um novo post podemos ver que agora ela se parece assim:
![formulario-com-bulma](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/form-bulma.png)

Agora se tentarmos salvar um novo post veremos que ele ainda não está gravando, para isso precisamos voltar ao controller e alterar para:
```php
/**  
 * @Route("/post/create", name="post.create")  
 * @param Request $request  
  * @return Response  
 */public function create(Request $request)  
{  
  // cria um novo post com titulo  
  $post = new Post();  
  
  // cria um novo formulário usando PostType de modelo que após preenchido  
 // passa as informações para o objeto $post  $form = $this->createForm(PostType::class, $post);  
  
  $form->handleRequest($request);  
  
 if($form->isSubmitted()) {  
  // entity manager  
  $em = $this->getDoctrine()->getManager();  
  $em->persist($post); // salva o Objeto Post na tabela post  
  $em->flush();  
  
  $this->addFlash('success', 'O post ' . $post->getTitle() . ' foi criado.' );  
  
 return $this->redirect($this->generateUrl('post'));  
  }  
  
  // return a response  
  return $this->render('post/create.html.twig', [  
  'form' => $form->createView()  
 ]);  
}
```
O que fizemos aqui? Primeiro adicionamos a requisição em handleRequest() que é uma função que irá pegar todos os dados do formulário passados por post e adicionar no nosso objeto $post que foi passado antes ao formulário. Depois adicionamos um if que checa se esse método é chamado em caso de ser uma submissão do nosso formulário, caso seja ele grava o objeto post no Banco e depois redireciona para a lista de posts com uma flash message de sucesso.
![novo-post](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/novo-post.png)
Certo agora vamos adicionar um botão para adicionar um novo post abaixo da nossa lista de posts para isso basta adicionar o seguinte código em template/post/index.html.twig abaixo da nossa tabela:
```twig
<div class="field">  
 <a href="{{ path('post.create') }}"><button class="button is-primary is-pulled-right">New Post</button></a>  
</div>
```
E com isso teremos:
![botao novo post](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/tela-com-botao.png)

Uma última coisa que talvez queremos fazer com nosso formulário é **validação**, para isso devemos ir até a nossa entidade em src/Entity/Post.php, para que possamos adicionar validação de formulário precisamos primeiro importar a seguinte classe:
```php
use Symfony\Component\Validator\Constraints as Assert;
```
Então podemos por exemplo dizer que o título no formulário não pode ser enviado em branco, para isso adicionamos a annotation @Assert como importamos com NotNull na propriedade title:
```php
/**  
 * @Assert\NotBlank
 * @ORM\Column(type="string", length=255)  
 */
 private $title;
 ```
 Agora temos que adicionar a validação no método create do PostController e para isso é muito simples: basta adicionar a condição isValid() no if que checa quando o formulário foi enviado:
 ```php
 if($form->isSubmitted() && $form->isValid()) {  
  // entity manager  
  $em = $this->getDoctrine()->getManager();  
  $em->persist($post); // salva o Objeto Post na tabela post  
  $em->flush();  
  
  $this->addFlash('success', 'O post ' . $post->getTitle() . ' foi criado.' );  
  
  return $this->redirect($this->generateUrl('post'));  
}
 ```
Pronto, agora se tentarmos enviar o formulário em branco veremos a mensagem 'Preencha este campo' enviada pelo navegador.

### Debug
Para podermos fazer o profilling e debug do nosso projeto em Symfony usamos um pacote PHP chamado php-debugbar alterado para Symfony que pode ser instalado utilizando o seguinte comando: 
```composer require web-profiler-bundle```
E então aparecerá essa barra que irá nos dar várias informações sobre o nosso projeto:
![php debuggbar no symfony](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/debugbar.png)
### Segurança

Assim como o Spring tem o Spring Security, o Symfony também possui um componente chamado Security responsável por autentições, logins e demais formas de autenticação. Como sempre, ele não vem instalado por padrão e precisamos usar o composer para dizer ao Symfony que precisamos dele:
```composer require security```
Após instalarmos o componente já podemos fazer nossa tela de login, mas antes precisamos criar um unuário que possa ser autenticado para isso utilizamos o comando make:
``` php bin/console make:user```
Após entrarmos com esse comando o console irá fazer algumas perguntas:

 -  The name of the security user class (e.g. User) [User]:
 \> [Enter]
 -  Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
  \> [Enter]
 -  Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
  \> **username**
 -  Does this app need to hash/check user passwords? (yes/no) [yes]: 
  \> [Enter]

 utilizar o comando make para criar uma autenticação:
``` php bin/console make:auth```
Após entrarmos com esse comando o console irá fazer algumas perguntas:

- What style of authentication do you want? [Empty authenticator]: <br>
  [0] Empty authenticator<br>
  [1] Login form authenticator
\> **1**
-  The class name of the authenticator to create (e.g. AppCustomAuthenticator):
\> **CustomAuthenticator**
- Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
\> [Enter]
-  Do you want to generate a '/logout' URL? (yes/no) [yes]:
\> [Enter]

Legal, agora para sabermos tudo o que foi adicionado para nós podemos utilizar o comando debug para listar todas as rotas ativas na nossa aplicação:
``` php bin/console debug:router ```
Vamos perceber que várias rotas com '_' (underline) na frente foram criadas, não precisamos nos preocupar com essas rotas, elas servem para auxiliar o Symfony apenas, o que nos interessa são as rotas /login e /logout que serão responsaveis pela autenticação do usuário.

Mas antes que possamos fazer login primeiro precisamos fazer a migração da entidade User para nosso Banco de Dados, você lembra o comando para isso?
``` php bin/console doctrine:schema:update --force ```

Legal agora se acessarmos nossa página http://localhost/sftutorial/public/index.php/login veremos que o Symfony já montou  uma tela de login básica para nós!
![login symfony](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/login-basico.png)
Porém se consultarmos através do MySQL a tabela User veremos que ela está vazia, ainda não temos nenhum usuário registrado o que nos impossibilita de fazer login. Como resolvemos isso? Simples, usamos o Symfony para que ele nos gere um controller para registro:
``` php bin/console make:controller RegistrationController ```
Em src/Controller/RegistrationController.php vamos apagar o método index e adicionar um método register que irá utilizar o createFormBuilder para criar um formulário simples de registro e passar para a view registration/index.html.twig:
```php
/**  
 * @Route("/register", name="register")  
 * @param Request $request  
  * @param UserPasswordEncoderInterface $encoder  
  * @return Response  
 */
public function register(Request $request, UserPasswordEncoderInterface $encoder)  
{
  // cria o formulário de registro
  $form = $this->createFormBuilder()  
	 ->add('username')  
	 ->add('password', RepeatedType::class, [  
		'type' => PasswordType::class,  
		'required' => true,  
		'first_options' => ['label' => 'Password'],  
		'second_options' => ['label' => 'Repeat Password']  
	 ]) 
	 ->add('save', SubmitType::class)  
	 ->getForm()  
  ;  
 $form->handleRequest($request);  
 if($form->isSubmitted() && $form->isValid()) {  
	  // pega os dados do formulário  
	  $data = $form->getData();  
  
	  // cria o objeto User a ser persistido  
	  $user = new User();  
	  $user->setUsername($data['username']);  
	  $user->setPassword($encoder->encodePassword($user, $data['password']));  
  
	  // persist the data  
	  $em = $this->getDoctrine()->getManager();  
	  $em->persist($user);  
	  $em->flush();  
  
	 return $this->redirect($this->generateUrl('app_login'));  
  }  
  return $this->render('registration/index.html.twig', [  
	  'controller_name' => 'RegistrationController',  
	  'form' => $form->createView()  
 ]);  
}
```
E agora precisamos renderizar isso na view, para isso altere o conteúdo de registration/index.html.twig para:
```twig
{% extends 'base.html.twig' %}  
  
{% block title %} Register {% endblock %}  
  
{% block body %}  
    {{ form(form) }}  
{% endblock %}
```
E quando acessarmos a página http://localhost/sftutorial/public/index.php/register devemos ver:
![registration page](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/registration-page.png)
Agora se nos registrarmos seremos redirecionados para a página de login, mas se observarmos no nosso Banco MySQL veremos que nosso usuário está lá com sua senha criptografada pelo UserPasswordEncoderInterface que recebe Depedency Injection de uma classe concreta que faz o hash em Argon2 utilizando a biblioteca libsodium do PHP.
![sql user](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/sql-user.png)
Mas antes que possamos fazer login com nosso novo usuário precisamos ir em src/Security/CustomAuthenticator.php e alterar a linha que diz:
```php
// For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));  
throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
```
por:
```php
return new RedirectResponse($this->urlGenerator->generate('post'));
```
Essa linha diz para onde o usuário deve ser redirecionado após fazer o login, por padrão quando geramos a autenticação ela vem com TODO - a fazer - e lançando propositalmente uma exceção/erro justamente para que o usuário diga para o Symfony essa informação. Pronto! agora podemos fazer login e após o login ser concluido seremos redirecionados para a listagem de posts. Observe que na barra de debug onde dizia 'anon' agora diz o nome do usuário, isso significa que nosso login funcionou. Para deslogar basta acessar a página /logout e o usuário será deslogado e redirecionado para '/' por padrão.
![user logged in bar](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/user-logged.png)
Outra coisa que queremos fazer é dizer o que um usuário logado e/ou deslogado pode ou não ver, para isso devemos ir em config/packages/security.yaml e dizer quais rotas um usuário logado ou deslogado pode ver alterando os valores de access_control para:
```yaml
# Easy way to control access for large sections of your site  
# Note: Only the *first* access control that matches will be used  
access_control:  
    - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }  
    - { path: ^/register, roles: IS_AUTHENTICATED_ANONYMOUSLY }  
    - { path: ^/, roles: ROLE_USER }
```
Agora apenas usuários autenticados podem ver nossas páginas, caso não esteja autenticado será redirecionado para '/login'. 

Uma última coisa que queremos fazer é exibir o link para login para usuários não cadastrados e logout para os autenticados. Para isso vamos alterar nosso template base.html.twig:
``` twig
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
 <img style="max-width: 30px;"  
  src="https://i0.wp.com/phpmagazine.net/wp-content/uploads/2018/12/symfony-logo-png-transparent.png?fit=2400%2C2410"  
  alt="Bulma: Free, open source, and modern CSS framework based on Flexbox" width="112" height="28">  
 </a>  
 <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">  
 <span aria-hidden="true"></span>  
 <span aria-hidden="true"></span>  
 <span aria-hidden="true"></span>  
 </a> </div>  
 <div id="navbarBasicExample" class="navbar-menu">  
 <div class="navbar-start">  
  {% if is_granted('IS_AUTHENTICATED_FULLY') %}  
	<a class="navbar-item" href="{{ path('post') }}">  
	  Posts  
        </a>  
  {% endif %}  
        </div>  
  
 </div> 
 <div class="navbar-end">  
 <div class="navbar-item">  
  {% if is_granted('IS_AUTHENTICATED_FULLY') %}  
                <div class="buttons">  
 <a class="button is-light" href="{{ path('app_logout') }}">  
  Logout  
                    </a>  
 </div>  {% else %}  
                <div class="buttons">  
 <a class="button is-primary" href="{{ path('register') }}">  
 <strong>Sign up</strong>  
 </a> <a class="button is-light" href="{{ path('app_login') }}">  
  Log in  
                    </a>  
 </div>  {% endif %}  
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
Pronto! Agora podemos ver que quando o usuário está autenticado ele vê o botão 'logout' e quando não está vê os botões 'sign in' e 'login'.
### Relações de tabelas usando Doctrine, parte 1
Atualmente nosso post tem apenas um título e nada mais. O que vamos fazer é adicionar uma imagem e uma categoria a cada post. Para isso teremos que mudar nossa entidade Post, teremos que adicionar um atributo 'image' que irá conter a imagem que faremos upload. Guardar arquivos binários como imagens diretamente no Banco de Dados nunca é uma boa idéia, por isso nossa propriedade será uma string que irá guardar o caminho onde nossa imagem será salva no servidor.

Primeiro precisamos adicionar a propriedade com a annotation do Doctrine para que ela possa ser mapeada posteriormente para o BD:
```php
/**
 * @ORM\Column(type="string", length=100) 
 */
private $image;
```
Então devemos criar os getter/setters para que essa propriedade possa ser acessada pelo restante do framework, para isso podemos escreve-los manualmente ou utilizar a linha de comando:
``` php bin/console make:entity --regenerate```
A linha de comando irá perguntar o namespace que precisa ser regenerado e então basta dar enter. Pronto, agora temos os getters e setters.
### Upload de Arquivos
Agora que temos nossa entidade que consegue armazenar o caminho das imagens precisamos fazer o upload de arquivos em si. Para isso precisamos adicionar um input file no nosso formulário de novo post. Vamos mudar o $builder para:
```php
$builder  
  ->add('title', null, [  
  'attr' => [  
  'class' => 'input'  
  ],  
  'row_attr' => [  
  'class' => 'field'  
  ],  
  'label_attr' => [  
  'class' => 'label'  
  ]  
 ]) ->add('image', FileType::class, [  
  'mapped' => false,  
  'row_attr' => [  
  'class' => 'field'  
  ],  
  'label_attr' => [  
  'class' => 'label'  
  ]  
 ]) ->add('save', SubmitType::class, [  
  'attr' => [  
  'class' => 'button is-primary'  
  ]  
 ]);
 ```
Note que adicionamos 'mapped' como falso, isso siginifica que esse campo não será automaticamente persistido e terá que ser tratado no controller, a documentação do symfony diz que isso é necessário caso quisermos salvar o arquivo em alguma pasta que não a temporária. 

Atualmente nossa tela de novo post deve estar assim:
![formulario com o campo de imagem](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/formulario-com-imagem.png)

Ok, como disse antes, agora teremos que tratar o arquivo no controller. Para isso teremos que alterar a função create em PostController
```php
/**  
 * @Route("/post/create", name="post.create")  
 * @param Request $request  
  * @return Response  
 */
public function create(Request $request)  
{  
  // cria um novo post com titulo  
  $post = new Post();  
  
  // cria um novo formulário usando PostType de modelo que após preenchido  
 // passa as informações para o objeto $post  
 $form = $this->createForm(PostType::class, $post);  
  
  $form->handleRequest($request);  
  
 if($form->isSubmitted() && $form->isValid()) {  
  $file = $request->files->get('post')['image'];  
  // entity manager  
  $em = $this->getDoctrine()->getManager();  
  $em->persist($post);  
 if ($file) {  
  // cria um nome único para cada imagem  
 // isso evita conflitos caso 2 tenham mesmo nome  
 $filename = md5(uniqid()) . '.' . $file->guessClientExtension();  
  
  // move as imagens, pega o valor de uploads_dir em services.yaml  
 // e renomeia o arquivo com o valor em $filename  
 $file->move($this->getParameter('uploads_dir'), $filename);  
  
  // adiciona o caminho ao post para que seja persistido  
  $post->setImage($filename);  
  }  
  $em->flush();  
  
  $this->addFlash('success', 'O post ' . $post->getTitle() . ' foi criado.' );  
  
 return $this->redirect($this->generateUrl('post'));  
  }  
  
  // return a response  
  return $this->render('post/create.html.twig', [  
  'form' => $form->createView()  
 ]);  
}
```
Agora precisamos alterar config/services.yaml para que tenhamos a chave que pegamos com <u>getParameter()</u>, para isso vamos adicionar um valor em parameters apontando o local da pasta em que vamos salvar os arquivos.
```yaml
parameters:  
    uploads_dir: '%kernel.project_dir%/public/uploads/'
```
 Agora precisamos migrar nossos novos campos para o BD para que possa recebe-los:
 ``` php bin/console doctrine:schema:update --force```
Após migrarmos os dados podemos enviar nosso arquivo que será salvo dentro de public/uploads/ e persistido.
![imagem salva](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/upload-feito.png)
Estamos quase prontos, para finalizarmos o upload de arquivos devemos também exibir a imagem salva quando acessarmos um de nossos posts. Para isso temos que ir no nosso template /post/show.html.twig e adicionar a imagem:
```twig
{% extends 'base.html.twig' %}  
  
{% block title %} {{ post.title }}{% endblock %}  
  
{% block body %}  
    <h1 class="title">ID: {{ post.id }} Titulo: {{ post.title }}</h1>  
 <img src="{{ '/sftutorial/public/uploads/' ~ post.image }}">  
{% endblock %}
``` 
**Obs:** O caminho '/sftutorial/public/uploads/' é para quem está usando apache sem virtualhost, para quem está usando htacess, emdded server do php ou symfony ou com o virtualhost configurado o caminho é '/uploads/' apenas.

Se tudo deu certo você deve estar vendo seus novos posts com imagens, parabéns!
![post com imagem](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/post-com-imagem.png)
### Relações de tabelas usando Doctrine, parte 2
Agora faremos uma relação entre duas entidades, sendo uma a categoria e outra post, sendo que uma categoria terá muitos posts enquanto um post terá uma categoria. Para isso primeiro precisamos criar uma entidade chamada de Category com apenas um atributo string name:
``` php bin/console make:entity ``` 
 Após entrarmos com esse comando o terminal irá fazer algumas perguntas sobre a entidade que vamos criar e vamos entrar com as seguintes respostas:
 -  Class name of the entity to create or update (e.g. FierceElephant): 
 \> **Category**
 -  New property name (press <return> to stop adding fields):
 \> **name**
 -  Field type (enter ? to see all types) [string]:
 \> [Enter]
 - Field length [255]:
 \> [Enter]
 - Can this field be null in the database (nullable) (yes/no) [no]:
  \> [Enter]
 -  Add another property? Enter the property name (or press <return> to stop adding fields):
 \> [Enter]
Legal, agora que temos nossa entidade devemos adicionar  uma propriedade 'category' na nossa entidade Post com a annotation ORM ManyToOne que define a relação e tem dois parametros: o primeiro é qual a outra entidade - incluindo seu namespace - e o outro é qual propriedade nessa entidade faz referência a essa:
```php
/**  
 * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="post")  
 */
 private $category;
``` 
Agora precisamos adicionar uma propriedade 'post' em Category:
```php
/**  
 * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="category")  
 */
 private $post;
```
E agora precisamos regenerar nossas entidades para que elas possuam os getter e setters dessas classses adequados, note que não serão os mesmos de propriedades comuns pois farão os mapeamentos entre ambas entidades:
``` php bin/console make:entity --regenerate```
Após isso precisamos migrar nossas mudanças nas entidades para que o banco de dados corresponda a essas mudanças:
``` php bin/console doctrine:schema:update --force```
Certo, agora precisamos adicionar um input em nosso formulário que possamos dizer à qual categoria aquele post pertence, para isso novamente vamos mudar o $builder em src/Form/PostType.php:
```php
$builder  
  ->add('title', null, [  
  'attr' => [  
  'class' => 'input is-primary'  
  ],  
  'row_attr' => [  
  'class' => 'field'  
  ],  
  'label_attr' => [  
  'class' => 'label'  
  ]  
 ]) ->add('image', FileType::class, [  
  'mapped' => false,  
  'row_attr' => [  
  'class' => 'field'  
  ],  
  'label_attr' => [  
  'class' => 'label'  
  ]  
 ]) ->add('category', EntityType::class, [  
  'class' => Category::class,  
  'label' => false,  
  'row_attr' => [  
  'class' => 'field select is-rounded is-primary'  
  ],  
  
  ])  
 ->add('save', SubmitType::class, [  
  'attr' => [  
  'class' => 'button is-primary'  
  ]  
 ]);
```
Certo, agora temos que inserir algumas categorias no banco, para isso você pode usar o gerenciador MySQL de sua preferência - phpMyAdmin, Adminer, Navicat, DBeaver... - eu vou utilizar o integrado na IDE por ser mais prático:
![insert sql](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/sql.png)
Após inserirmos se tentarmos acessar a página veremos que ela retorna um erro que diz que o objeto não pode ser convertido para string, para que isso seja possivel precisamos implementar um método mágico __toString() na classe Category:
``` php
public function __toString()  
{  
  return $this->getName();  
}
```
Legal, agora tudo deve estar funcionando. A nova tela de cadastro se parecera com esta:
![formulario novo](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/formulario-novo-bulma.png)
Agora queremos que a categoria apareça na página que exibe as informações do post, para isso vamos alterar o template /post/show.html.twig:
```twig
{% extends 'base.html.twig' %}  
  
{% block title %} {{ post.title }}{% endblock %}  
  
{% block body %}  
    <h1 class="title">ID: {{ post.id }} Titulo: {{ post.title }}</h1>  
 <em>{{ post.category }}</em>  
 <hr> <img src="{{ '/sftutorial/public/uploads/' ~ post.image }}">  
{% endblock %}
```
Agora quando acessamos um post ele deve parecer-se com isso:
![post com categoria](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/post-com-categoria.png)