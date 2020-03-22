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
