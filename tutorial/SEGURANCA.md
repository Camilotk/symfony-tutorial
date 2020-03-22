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
