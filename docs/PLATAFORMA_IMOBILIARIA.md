# Estrutura Profissional — HomeFinder

## Objetivo
Transformar o HomeFinder em uma plataforma imobiliária completa com:

- Controle de sessão e autenticação
- Separação de perfis (Cliente e Vendedor)
- Chat interno entre usuários
- Sistema de publicação de imóveis
- Pagamento de taxas de publicação
- Sistema de planos e assinaturas
- Gestão de favoritos
- Gestão de visitas
- Avaliações
- Painel administrativo
- Segurança e auditoria

---

# Arquitetura Recomendada

## Tipos de usuários

### Cliente
Pode:
- Pesquisar imóveis
- Favoritar imóveis
- Conversar com vendedores
- Solicitar visitas
- Fazer propostas
- Avaliar vendedores

### Vendedor
Pode:
- Publicar imóveis
- Pagar taxa de publicação
- Gerenciar anúncios
- Responder clientes
- Ver métricas
- Contratar planos premium

---

# Sistema de Sessões

## Sessão autenticada
Usar middleware `auth` + `role`.

## Controle de permissões
Middleware:
- role:cliente
- role:vendedor
- role:admin

---

# Estrutura de Banco de Dados

## users
Tabela principal de autenticação.

Campos importantes:
- id
- name
- email
- password
- role
- status
- telefone
- avatar
- ultimo_login

---

## vendedores
Dados profissionais do vendedor.

Campos:
- user_id
- nif
- bi
- verificado
- reputacao

---

## imoveis
Informações do imóvel.

Campos novos recomendados:
- status_publicacao
- destaque
- visualizacoes
- expiracao_publicacao
- latitude
- longitude
- tipo_negocio

---

## conversas
Responsável pelo chat.

Relaciona:
- cliente
- vendedor
- imóvel

---

## mensagens
Mensagens enviadas.

Campos:
- conversa_id
- remetente_id
- mensagem
- lida

---

## publicacoes_pagamento
Controla taxas pagas.

Campos:
- vendedor_id
- imovel_id
- valor
- metodo_pagamento
- status
- referencia

---

## favoritos
Imóveis favoritos.

---

## visitas
Pedidos de visita.

---

## avaliacoes
Avaliação de vendedores.

---

# Fluxo de Publicação

1. Vendedor cria anúncio
2. Sistema valida dados
3. Sistema gera cobrança
4. Pagamento confirmado
5. Imóvel publicado
6. Anúncio expira automaticamente

---

# Algoritmo de Recomendação

## Critérios

- Localização
- Faixa de preço
- Tipo de imóvel
- Histórico do usuário
- Imóveis mais visualizados
- Imóveis premium

## Estratégia

Pontuação:

score =
(localizacao * 0.35)
+ (preco * 0.20)
+ (interesse * 0.25)
+ (popularidade * 0.20)

---

# Funcionalidades Premium

## Plano Básico
- 3 anúncios

## Plano Profissional
- Destaque na página inicial
- Estatísticas
- Mais anúncios

## Plano Enterprise
- Destaque premium
- Prioridade nas pesquisas
- Relatórios completos

---

# Segurança

## Necessário

- CSRF
- Rate limiting
- Verificação de email
- Criptografia de senhas
- Logs de auditoria
- Upload seguro de imagens

---

# Tecnologias Recomendadas

## Backend
- Laravel
- Sanctum
- Queue Jobs
- Policies

## Frontend
- Bootstrap
- Vue.js (opcional)

## Banco
- MySQL

## Pagamentos
- Stripe
- PayPal
- Referência bancária angolana

---

# Escalabilidade

## Futuro

- Aplicativo mobile
- Notificações em tempo real
- IA para recomendação
- Integração com mapas
- Sistema anti-fraude

