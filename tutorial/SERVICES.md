### Services
Esse será o último tópico desse tutorial. Basicamente um _Service_ (Serviço) é qualquer Classe do Symfony. Durante esse tutorial usamos diversos serviços e o Symfony é baseado em Serviços (o que poderiamos pensar como módulos). Todos os serviços estão dentro de algo chamado _Container_ que você pode pensar como uma caixa que contêm diversos objetos que precisamos. Para ver todos os serviços que temos em nosso projeto Symfony podemos usar:
``` php bin/console debug:container ``` 
Para exemplificar melhor como criar um serviço, vamos transformar a parte de upload de imagens em um serviço que irá tornar nosso código um pouco bagunçado nessa parte em algo mais organizado e efetivo. Para melhor oganizar nossas Classes de serviço vamos criar uma pasta src/Service e dentro vamos criar um arquivo php chamado Uploader.php e dentro dessa classe vamos adicionar nossa função de upload:
```php
class Uploader  
{  
  /**  
 * @var ContainerInterface  
 */  
 private $container;  
  
 public function __construct(ContainerInterface $container)  
 {  
 $this->container = $container;  
 }  
  public function uploadFile(UploadedFile $file)  
 {  
 // cria um nome único para cada imagem  
 // isso evita conflitos caso 2 tenham mesmo nome  
 $filename = md5(uniqid()) . '.' . $file->guessClientExtension();  
  
  // move as imagens, pega o valor de uploads_dir em services.yaml  
 // e renomeia o arquivo com o valor em $filename  
 $file->move($this->container->getParameter('uploads_dir'), $filename);  
  
 return $filename;  
  }  
}
```
e agora vamos alterar nosso método create em PostController para utilizar nosso Service:
```php
/**  
 * @Route("/post/create", name="post.create")  
 * @param Request $request  
  * @return Response  
 */public function create(Request $request, Uploader $uploader)  
{  
  // cria um novo post com titulo  
  $post = new Post();  
  
  // cria um novo formulário usando PostType de modelo que após preenchido  
 // passa as informações para o objeto $post  $form = $this->createForm(PostType::class, $post);  
  
  $form->handleRequest($request);  
  
 if($form->isSubmitted() && $form->isValid()) {  
  $file = $request->files->get('post')['image'];  
  // entity manager  
  $em = $this->getDoctrine()->getManager();  
  $em->persist($post);  
 if ($file) {  
  $filename = $uploader->uploadFile($file);  
  
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
Ótimo se testar agora verá que tudo <strike>deve</strike> continuar funcionando. Foi um exemplo simples, mas imagine que agora precizassemos fazer uma função que deleta a imagem e que é chamada antes de deletar o post, ou uma que recebe duas imagens deleta a primeira e salva a segunda para atualizar isso tudo ficaria contido em uma única classe com essa responsabilidade e isso é muito **dahora**.

**Parabéns** você sobreviveu até aqui e agradeço muito pelo seu interesse em seguir esse tutorial! Agora você deve saber o básico necessário para criar seus sistemas com Symfony e poderá fazer sites incriveis como o <strike><bold>pornhub e</bold></strike> Dailymotion.
