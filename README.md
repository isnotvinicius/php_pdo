# Conexão com banco de dados utilizando PDO

## O que é PDO?

- É uma extensão que define uma forma leve e consistente para acessar banco de dados em php. Ele utiliza drivers específicos de banco de dados para fazer a conexão de maneira correta.

- Para utilizar basta criar o objeto PDO e passar os parâmetros. Se utilizado de forma genérica a instância será quase sempre a mesma precisando mudar apenas o dsn, ou seja, a string de conexão, esta que muda de acordo com o banco de dados utilizado. Podemos passar também o usuário, senha e parâmetros extras quando necessário.


## Executando comandos

- Para executar comandos como create table ou insert de dados podemos chamar o método exec do PDO utilizando o objeto instânciado "$pdo->exec('statement');" onde statement é o comando ou a string com o comando.

## Busca de dados

- Através do método query podemos colocar um comando select e chamar o método FetchAll para selecionar todos os campos. 

- É possível formatar o estilo do fetch passando o parâmetro na chamada do método, o mais comum é utilizar o PDO::FETCH_ASSOC e criar um foreach para instânciar os objetos corretamente com os nomes colocados no banco de dados. Caso os objetos da classe e os nomes das colunas sejam iguais é possível utilizar o PDO::FETCH_CLASS eliminando o foreach.

- Quando retornamos apenas um parâmetro, uma linha só, é possível utilizar apenas o fetch.

- O método fetch traz uma ótima vantagem como mostrado no código abaixo. Através de um while podemos colocar uma váriavel qualquer e chamar o método fetch passando o PDO::FETCH_ASSOC e instânciar os objetos corretamente dentro do loop. Isso fará com que a cada parâmetro seja criado um objeto e no final da execução do while o objeto deixa de existir, ou seja, é criado um objeto por vez e no final do loop ele é apagado. Isto ajuda quando iremos retornar muitos valores e queremos evitar o consumo alto de memória. 

```
while ($váriavel = $statement->fetch(PDO::FETCH_ASSOC)){
    $objeto = new Class();
}

```

- Para saber outros modos de formatação do fetch basta checar <a>https://www.php.net/manual/en/pdostatement.fetch#refsect1-pdostatement.fetch-parameters</a>


## SQL Injection, como evitar?

- Para evitar um ataque de SQL Injection pela manipulação de dados podemos utilizar o que chamamos de prepared statement. 

- Criamos o comando adicionando um simbolo de interrogação nos parâmetros passados e após isso utilizamos o método prepare do pdo passando a string do comando como parâmetro.

- Depois de chamar o método prepare utilizamos o método bindValue passando como parâmetro a posição do dado no comando e qual o valor que será armazenado.

```
$statement->bindValue(1, $student->name());
$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));

```

- Após preparar o comando e informar quais dados serão armazenados podemos executar chamando o método execute ao invés do método exec. "$statement->execute();"

- É possível substituir as interrogações por ":name" e na hora de chamar o bindValue utilizamos esse nome ao invés da posição.

- Podemos utilizar o bindParam para utilizar a passagem por referência.

- Por padrão os valores passados são sempre string, caso precisemos passar outro tipo basta adicionar como terceiro parâmetro no bindValue PDO::PARAM_TIPO-DADO.
