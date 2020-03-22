### Relações de tabelas usando Doctrine, parte 1
Atualmente nosso post tem apenas um título e nada mais. O que vamos fazer é adicionar uma imagem e uma categoria a cada post. Para isso teremos que mudar nossa entidade Post, teremos que adicionar um atributo 'image' que irá conter a imagem que faremos upload. Guardar arquivos binários como imagens diretamente no Banco de Dados nunca é uma boa idéia, por isso nossa propriedade será uma string que irá guardar o caminho onde nossa imagem será salva no servidor.

Primeiro precisamos adicionar a propriedade com a annotation do Doctrine para que ela possa ser mapeada posteriormente para o BD:
```php
/**
 * @ORM\Column(type="string", length=100) 
 */
private $image;
```
Então devemos criar os getter/setters para que essa propriedade possa ser acessada pelo restante do framework, para isso podemos escreve-los manualmente ou utilizar a linha de comando:
``` php bin/console make:entity --regenerate```
A linha de comando irá perguntar o namespace que precisa ser regenerado e então basta dar enter. Pronto, agora temos os getters e setters.
