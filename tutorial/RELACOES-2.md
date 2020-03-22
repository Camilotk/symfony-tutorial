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
