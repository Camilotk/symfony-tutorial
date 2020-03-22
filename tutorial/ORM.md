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
