### Views
Para renderizar as views o Symfony utiliza o template engine [Twig](https://twig.symfony.com/) que ajuda a separar a lógica da apresentação no projeto. O Twig irá renderizar o código php dentro de {{ }} para html muito similar à quando usamos <?php ?>, mas com diversas vantagens, como pré-compilação, cache e escaping. Antes de mais nada precisamos instalar o Twig no projeto, para isso usamos o composer: ```composer require symfony/twig-bundle```.

Após termos instalado o Twig devemos criar uma pasta com o nome 'templates' dentro da **raíz do nosso projeto**, essa pasta irá conter todos os arquivos de view que criarmos. Agora dentro dessa pasta vamos criar uma outra pasta chamada 'home' que vai conter todos os nossos templates relacionados com a página 'home' e dentro um arquivo chamado custom.html.twig.

![Estrutura de pastas](https://github.com/Camilotk/symfony-sisint-ifrs/blob/master/imagens/folders.png)

Devemos refatorar nosso código custom mudando o retorno que agora não vai ser mais o retorno json, mas a função render() herdada de AbstractController que recebe o nome ou caminho do arquivo que será renderizado de dentro da pasta 'templates'.  Além disso, precisamos passar a todas as variáveis que a View precisa dentro de um array em que a chave será o nome da variável na view e o valor a variável no controller.
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
