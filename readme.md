Sistema de Gerenciamento via Terminal(Adaptado pra web)

Crie um sistema de gerenciamento que rode no terminal usando PHP puro (sem frameworks).
O sistema deve ter um menu interativo com as seguintes funcionalidades:

- **Cadastrar** um novo registro com pelo menos 4 campos (sendo pelo menos 1 string, 1 inteiro e
  1 booleano)
- **Listar** todos os registros cadastrados, ordenados alfabeticamente
- **Buscar** registros por nome (busca parcial e case-insensitive)
- **Editar** um registro existente (permitindo manter valores atuais ao pressionar Enter)
- **Remover** um registro com confirmação antes de excluir
- **Estatísticas** — exibir pelo menos 3 informações calculadas a partir dos dados (ex: total, média,
  contagem por status)

### Regras

1. Os dados devem ser armazenados em um **array de arrays associativos**
2. Cada registro deve ter um **ID único** gerado automaticamente
3. Todos os inputs do usuário devem ser **validados** antes de salvar
4. O código deve ser separado em dois arquivos ou mais
5. O menu deve rodar em **loop infinito** até o usuário escolher sair

### Exemplos de temas

Você pode criar um sistema de gerenciamento para qualquer tema. Alguns exemplos:

- Contatos (nome, email, telefone, idade)
- Livros (titulo, autor, paginas, lido/nao lido)
- Tarefas (descricao, prioridade, prazo, concluida)
- Produtos (nome, preco, quantidade, disponivel)
- Alunos (nome, matricula, nota, aprovado)