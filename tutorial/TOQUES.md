
### Ajustes finais
Certo, agora não tem muito mais o que eu possa te ensinar de Symfony, mas que tal fazermos alguns ajustes no nosso microblog para que ele seja realmente um microblog?

Primeiro vamos alterar templates/home/index.html.twig para que exiba todos nossos posts com titulo e categoria:
```twig
{% extends('base.html.twig') %}  
{% block title %} Home {% endblock %}  
{% block body %}  
    <div class="content is-large">  
 <h1>Meu Blog</h1>  
 <p>Microblog com minhas imagens e fotos preferidas</p>  
 </div>  
 <div class="columns is-multiline">  
  {% for post in posts %}  
        <div class="column is-one-quarter-desktop is-half-tablet">  
 <div class="card">  
 <div class="card-image">  
 <figure class="image is-3by2">  
 <img src="{{ '/sftutorial/public/uploads/' ~ post.image  }}" alt="">  
 </figure> <div class="card-content is-overlay is-clipped">  
 <span class="tag is-info">  
  {{post.category}}  
              </span>  
 </div> </div> <footer class="card-footer">  
  {{ post.title }}  
                </footer>  
 </div> </div>  {% endfor %}  
    </div>  
{% endblock %}
```
 Agora vamos alterar o método index em MainController para passar todos os posts para nossa index:
```php
/**  
 * @Route("/main", name="main")  
 */public function index(PostRepository $repository)  
{  
  $posts = $repository->findAll();  
 return $this->render('home/index.html.twig', compact('posts'));  
}
```
Certo, se você tentar acessar http://localhost/sftutorial/public/index.php/main logado deve ver:
#image

Agora vamos deixar essa rota disponível para usuários visitantes em config/packages/security.yaml altere access_control para:
```yaml
# Easy way to control access for large sections of your site  
# Note: Only the *first* access control that matches will be used  
access_control:  
    - { path: ^/main, roles: IS_AUTHENTICATED_ANONYMOUSLY }  
    - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }  
    - { path: ^/register, roles: IS_AUTHENTICATED_ANONYMOUSLY }  
    - { path: ^/, roles: ROLE_USER }
```
Certo, lembrando que para fazer com que quando o usuário acessar www.meusite.com.br basta fazer o htaccess ou o vhost apontar para esse endereço.

Agora que temos nossa linda main page vamos também estilizar nossas telas de login e sign up que ficaram sem estilização pela pressa, primeiro vamos alterar templates/security/login para:
```twig
{% extends 'base.html.twig' %}  
  
{% block title %}Log in!{% endblock %}  
  
{% block body %}  
    <form method="post">  
  {% if error %}  
            <div class="alert alert-danger">{{ error.messageKey|trans(error.messageData, 'security') }}</div>  
  {% endif %}  
  
        {% if app.user %}  
            <div class="mb-3">  
  You are logged in as {{ app.user.username }}, <a href="{{ path('app_logout') }}">Logout</a>  
 </div>  {% endif %}  
  
        <h1 class="h3 mb-3 font-weight-normal subtitle">Please sign in</h1>  
 <div class="field">  
 <label for="inputUsername" class="label">Username</label>  
 <div class="control">  
 <input type="text" value="{{ last_username }}" name="username" id="inputUsername"  
  class="input is-primary"  
  required autofocus>  
 </div> </div> <div class="field">  
 <label for="inputPassword" class="label">Password</label>  
 <div class="control">  
 <input type="password" name="password" id="inputPassword" class="input is-primary" required>  
 </div> </div> <input type="hidden" name="_csrf_token"  
  value="{{ csrf_token('authenticate') }}"  
  >  
  
 <div class="field">  
 <div class="control">  
 <label class="checkbox">  
 <input type="checkbox" name="_remember_me"> Remember me  
                </label>  
 </div> </div>  
 <div class="field is-grouped">  
 <div class="control">  
 <button class="button is-rounded is-primary" type="submit">  
  Sign in  
                </button>  
 </div> </div> </form>{% endblock %}
```
Que deve deixar a página com essa aparência:
#image

Agora precisamos alterar src/Controller/RegistrationController.php alterando a variavel $form para:
```php
$form = $this->createFormBuilder()  
 ->add('username', null, [  
  'attr' => [  
  'class' => 'input is-primary'  
  ],  
  'row_attr' => [  
  'class' => 'field'  
  ],  
  'label_attr' => [  
  'class' => 'label'  
  ]  
 ]) ->add('password', RepeatedType::class, [  
  'type' => PasswordType::class,  
  'required' => true,  
  'first_options' => [  
  'label' => 'Password',  
  'attr' => [  
  'class' => 'input is-primary'  
  ],  
  'row_attr' => [  
  'class' => 'field'  
  ],  
  'label_attr' => [  
  'class' => 'label'  
  ]  
 ],  
  'second_options' => [  
  'label' => 'Repeat Password',  
  'attr' => [  
  'class' => 'input is-primary'  
  ],  
  'row_attr' => [  
  'class' => 'field'  
  ],  
  'label_attr' => [  
  'class' => 'label'  
  ]  
 ],  
  
  ])  
 ->add('save', SubmitType::class, [  
  'attr' => [  
  'class' => 'button is-primary'  
  ]  
 ]) ->getForm()  
;
```
Que deve deixar a tela de registro com essa aparência:
#image