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
