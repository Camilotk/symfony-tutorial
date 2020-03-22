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
