### Flash Message

Você deve ter notado que quando clicamos em um link 'delete' a página simplemente dá refresh sem avisar nada ao usuário. Para adicionarmos uma mensagem temporária de que o post foi deletado com sucesso basta adicionarmos essa linha <u>antes do retorno</u> de remove() no PostController:
```php
$this->addFlash('success', 'O Post foi deletado');
``` 
E agora acima da nossa tabela de posts vamos adicionar:
```twig
{% for message in app.flashes('success') %}  
 <div class="message is-success">  
	 <div class="message-body">  
		  {{ message }}  
	 </div>  
 </div>
{% endfor %}
```
Que irá buscar na memória flash pelas mensagens com o nome 'success' e exibir acima da tabela sempre que alguém excluir um item e mostrar temporariamente para o usuário. Caso quisessemos fazer o mesmo com erro bastaria fazer outro for para erros e nele mudar todos os 'success' por 'danger'.
