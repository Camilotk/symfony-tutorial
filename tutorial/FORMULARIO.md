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
