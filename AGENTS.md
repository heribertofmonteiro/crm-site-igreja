## 🔁 Ordem Oficial de Execução e Coordenação entre Agentes

Esta seção define **a ordem obrigatória de atuação dos agentes** no projeto.  
Nenhum agente pode executar ações fora da sua fase designada.

---

## 🛡️ 1. AGENT_GUARDIAN — Supervisor Anti-Alucinação (SEMPRE ATIVO)

### Papel
- Autoridade máxima
- Valida todas as decisões
- Bloqueia alucinações
- Garante aderência ao AGENTS.md

### Regras
- Atua **antes, durante e depois** de qualquer outro agente
- Pode interromper qualquer execução
- Nenhuma ação é considerada válida sem sua aprovação

---

## 🗄️ 2. AGENT_ARCHITECT_DATA — Arquitetura e Integridade

### Executa APENAS após aprovação do AGENT_GUARDIAN

### Responsabilidades
- Definir domínios (DDD)
- Modelar entidades, agregados e regras de negócio
- Definir estrutura de banco de dados
- Criar migrations, models e relacionamentos
- Definir contratos de API
- Criar CRUDs **somente após domínio validado**
- Criar views usando **AdminLTE 4 + Bootstrap 5**

### Restrições
- Não implementa funcionalidades sem domínio definido
- Não cria UI sem regras de negócio claras
- Não antecipa decisões técnicas

---

## 🛠️ 3. AGENT_LOGS — Logs, Erros e Observabilidade

### Executa após a arquitetura base estar definida

### Responsabilidades
- Configurar logs centralizados
- Padronizar tratamento de exceções
- Criar middleware de erro
- Garantir rastreabilidade de falhas

### Restrições
- Não altera regras de negócio
- Não cria modelos ou domínios

---

## 🛠️ 4. AGENT_REFACTOR — Análise Técnica e Refatoração

### Executa SOMENTE após código funcional existir

### Responsabilidades
- Revisar código implementado
- Refatorar para Clean Code
- Melhorar performance
- Corrigir más práticas
- Garantir aderência a padrões Laravel

### Restrições
- Não cria novas funcionalidades
- Não altera regras de domínio
- Não muda stack tecnológica

---

## 🔄 Fluxo Oficial de Execução

1. AGENT_GUARDIAN valida escopo
2. AGENT_ARCHITECT_DATA define domínio e arquitetura
3. AGENT_GUARDIAN aprova
4. AGENT_ARCHITECT_DATA implementa estrutura e código base
5. AGENT_LOGS adiciona observabilidade
6. AGENT_REFACTOR revisa e melhora
7. AGENT_GUARDIAN faz validação final

---

## 🚫 Ações Proibidas Fora de Ordem

- Criar CRUD antes do domínio
- Criar UI antes das regras
- Refatorar código inexistente
- Implementar features sem validação do Guardian
- Introduzir tecnologias fora do stack oficial

---

## ✅ Critério de Continuidade

Se qualquer agente:
- Pular sua fase
- Invadir responsabilidade de outro
- Introduzir decisões não documentadas

➡️ A ação será revertida e reexecutada na ordem correta.

---

## 🎯 Objetivo Final

Garantir um fluxo de desenvolvimento:
- Previsível
- Auditável
- Sem conflitos entre agentes
- Livre de alucinação
- Fiel ao planejamento original


# 📘 Sistema de Governança e Gestão Eclesiástica: Guia Oficial e Arquitetura

Este documento serve como o **Guia Oficial de Governança e Operação**, definindo os agentes (humanos, sistemas ou híbridos) necessários para a administração eficiente de uma igreja de pequeno a médio porte. Ele estabelece responsabilidades, fluxos, integrações, a arquitetura técnica do sistema e um plano prático de implantação.

---

## 🔭 Visão Geral do Sistema

Sistema projetado para **organizar, governar e apoiar todas as áreas de uma igreja evangélica**, respeitando sua missão espiritual, administrativa e legal.

- ❌ Não existe vendas
- ❌ Não existe clientes
- ✅ Sistema baseado em **páginas e ferramentas**
- ✅ Consumido por **ministérios e departamentos**
- ✅ Controle por permissões
- ✅ Transparência e organização

### 🧭 Princípios do Sistema
- Centralização da informação
- Governança eclesiástica
- Transparência administrativa
- Segurança e confidencialidade
- Simplicidade operacional
- Conformidade legal e estatutária

---

## 🏗️ Arquitetura Técnica

- **Backend**: Laravel 12 & PHP 8.3
- **Frontend**: AdminLTE 4 + Bootstrap 5
- **Banco de Dados**: MySQL e redis
- **Autenticação**: RBAC (Role-Based Access Control)
- **Logs e auditoria**

### 🎨 Template Administrativo: AdminLTE 4
- 🌐 **Site oficial / Demo:** https://adminlte.io/themes/v4/
- 💻 **Repositório GitHub:** https://github.com/ColorlibHQ/AdminLTE
- **Motivos da escolha**: Interface moderna e responsiva, ideal para sistemas institucionais, sem foco comercial, fácil integração com Laravel e excelente suporte a dashboards.

---

## 🧩 Estrutura Organizacional e Agentes

Abaixo estão detalhados os agentes e os módulos do sistema que cada ministério/departamento consome.

### 1️⃣ Governança e Direção
Responsável pelo direcionamento estratégico, espiritual e legal da organização.

#### 1.1. Agente: Conselho Pastoral (Direção Espiritual )
*   **Tipo**: Humano (Colegiado)
*   **Missão**: Definir a visão teológica e direção espiritual da igreja.
*   **Responsabilidades**: Pregação, doutrina, disciplina eclesiástica, visão anual.
*   **Entradas**: Necessidades dos membros, direção divina, relatórios ministeriais.
*   **Saídas**: Plano de ensino, calendário anual espiritual, diretrizes doutrinárias.
*   **Integrações**: Conselho Administrativo, Líderes de Ministério.
*   **KPIs**: Crescimento espiritual (subjetivo), batismos, índice de frequência.
*   **Riscos**: Desvio doutrinário, burnout pastoral.
*   **Ferramentas**: Bíblia, Reuniões de Oração, Gestão de Tarefas (Ex: Trello/Asana).
*   **Periodicidade**: Semanal.

**Módulo de Software: Governança Pastoral**
*   **Abas**: Visão e Doutrina, Ensino, Aconselhamento, Relatórios.
*   **Páginas**: Plano Espiritual Anual, Agenda Pastoral, Calendário de Pregações, Registro de Aconselhamento, Relatórios Ministeriais.
*   **Ferramentas**: Agenda confidencial, Histórico pastoral por membro, Anotações restritas.
*   **Processos**: Definição da visão espiritual, Supervisão ministerial, Acompanhamento pastoral.

#### 1.2. Agente: Conselho Administrativo (Direção Executiva)
*   **Tipo**: Humano (Colegiado) / Híbrido (com suporte de IA para dados)
*   **Missão**: Garantir a saúde organizacional e legal da instituição.
*   **Responsabilidades**: Aprovação de orçamentos, contratações, decisões patrimoniais, validação do planejamento estratégico.
*   **Entradas**: Relatórios financeiros, pareceres jurídicos, propostas de projetos.
*   **Saídas**: Atas de reunião, aprovação de verbas, resoluções administrativas.
*   **Integrações**: Tesouraria, Secretaria, Jurídico.
*   **KPIs**: Saúde financeira (% reserva), conformidade legal (100%), % execução estratégica.
*   **Riscos**: Insolvência, processos legais, má gestão de recursos.
*   **Ferramentas**: ERP Eclesiástico, Dashboards de BI.
*   **Periodicidade**: Mensal.

---

### 2️⃣ Administração Geral
O "motor" operacional da igreja.

#### 2.1. Agente: Secretaria Geral
*   **Tipo**: Híbrido (Secretária + CRM)
*   **Missão**: Centralizar e organizar o fluxo de informações e documentos.
*   **Responsabilidades**: Atendimento, gestão da agenda da igreja, emissão de documentos (cartas, certificados), atualização cadastral.
*   **Entradas**: Solicitações de membros, novos visitantes, correspondências.
*   **Saídas**: Agenda atualizada, certificados, boletins, comunicados.
*   **Integrações**: Todos os departamentos.
*   **KPIs**: Tempo médio de resposta, % de cadastros atualizados.
*   **Riscos**: Perda de dados, falha na comunicação.
*   **Ferramentas**: CRM (ChurchCRM), WhatsApp Business, Google Workspace.
*   **Periodicidade**: Diária.

**Módulo de Software: Administração Geral**
*   **Abas**: Secretaria, Documentos, Agenda, Comunicação Interna.
*   **Páginas**: Cadastro Geral, Atas de Reunião, Comunicados Oficiais, Arquivo Institucional.
*   **Ferramentas**: Modelos de documentos, protocolo interno, notificações.
*   **Processos**: Organização administrativa, Registro institucional, Suporte aos ministérios.

---

### 3️⃣ Gestão de Pessoas e Liderança

#### 3.1. Agente: Coordenação de Voluntariado (RH Ministerial)
*   **Tipo**: Humano
*   **Missão**: Engajar, treinar e organizar os voluntários.
*   **Responsabilidades**: Recrutamento, integração de novos voluntários, gestão de escalas, resolução de conflitos.
*   **Entradas**: Novos convertidos/membros, necessidades dos ministérios.
*   **Saídas**: Escalas de serviço, voluntários treinados e alocados.
*   **Integrações**: Liderança de Ministérios, Secretaria.
*   **KPIs**: % de membros engajados em ministérios, taxa de retenção de voluntários.
*   **Riscos**: Sobrecarga de voluntários, falta de treinamento.
*   **Ferramentas**: Software de Escalas (Planning Center ou módulo do CRM).
*   **Periodicidade**: Semanal.

---

### 4️⃣ Gestão de Membros e Discipulado

#### 4.1. Agente: Gestor de Integração e Discipulado
*   **Tipo**: Híbrido (Humano + Automação de Régua de Relacionamento)
*   **Missão**: Garantir que o visitante se torne um membro maduro.
*   **Responsabilidades**: Acolhimento, classe de novos membros, batismo, trilho de crescimento.
*   **Entradas**: Fichas de visitantes, pedidos de batismo.
*   **Saídas**: Novos membros integrados, classe de batismo formada.
*   **Integrações**: Pequenos Grupos, Secretaria.
*   **KPIs**: Taxa de conversão (Visitante -> Membro), tempo médio de integração.
*   **Riscos**: Pessoas "esquecidas", falta de acompanhamento.
*   **Ferramentas**: CRM (Funil de Integração), Automação de E-mail/WhatsApp.
*   **Periodicidade**: Semanal.

---

### 5️⃣ Ministérios e Atividades Espirituais

#### 5.1. Agente: Coordenador de Ministérios
*   **Tipo**: Humano
*   **Missão**: Alinhar e supervisionar as áreas ministeriais (Infantil, Jovens, Louvor, etc.).
*   **Responsabilidades**: Reuniões de alinhamento, aprovação de calendários setoriais, mentoria de líderes.
*   **Entradas**: Planejamentos setoriais, problemas operacionais.
*   **Saídas**: Calendário unificado, líderes alinhados à visão.
*   **Integrações**: Conselho Pastoral, Eventos.
*   **KPIs**: Qualidade dos cultos/eventos (pesquisas), crescimento dos departamentos.
*   **Riscos**: "Ilhas" ministeriais.
*   **Ferramentas**: Gestão de Projetos (ClickUp/Trello).
*   **Periodicidade**: Mensal.

#### 5.2. Módulo: Louvor e Adoração
*   **Abas**: Escalas, Repertório, Ensaios, Cultos.
*   **Páginas**: Escala de Louvor, Cadastro de Músicos, Repertório Musical, Planejamento de Culto.
*   **Ferramentas**: Controle de disponibilidade, Checklist de culto, Notificações automáticas.
*   **Processos**: Planejamento litúrgico, Organização de equipes, Execução do culto.

#### 5.3. Módulo: Infantil e Ensino
*   **Abas**: Turmas, Professores, Conteúdo, Presença.
*   **Páginas**: Cadastro de Crianças, Materiais Didáticos, Registro de Presença, Calendário Educacional.
*   **Ferramentas**: Controle de turmas, Planejamento de aulas, Relatórios pedagógicos.
*   **Processos**: Ensino bíblico infantil, Organização de classes, Acompanhamento pedagógico.

#### 5.4. Módulo: Jovens e Adolescentes
*   **Abas**: Grupos, Programação, Discipulado.
*   **Páginas**: Cadastro de Jovens, Eventos Jovens, Materiais de Ensino.
*   **Ferramentas**: Comunicação interna, Planejamento de encontros.
*   **Processos**: Discipulado, Integração, Formação espiritual.

---

### 6️⃣ Comunicação e Evangelismo

#### 6.1. Agente: Hub de Comunicação
*   **Tipo**: Híbrido (Equipe Criativa + Ferramentas de IA)
*   **Missão**: Propagar a mensagem do Evangelho e as atividades da igreja com excelência.
*   **Responsabilidades**: Gestão de redes sociais, transmissão ao vivo (streaming), design gráfico, site/app, mural de avisos.
*   **Entradas**: Agenda de eventos, sermões (para cortes), avisos da secretaria.
*   **Saídas**: Posts, vídeos, transmissões, newsletter.
*   **Integrações**: Todos os ministérios.
*   **KPIs**: Engajamento online, alcance das publicações, qualidade da transmissão.
*   **Riscos**: Ruído na comunicação, imagem institucional arranhada.
*   **Ferramentas**: Canva/Adobe, OBS Studio, Buffer/Hootsuite, IA Generativa.
*   **Periodicidade**: Diária.

**Módulo de Software: Comunicação e Mídia**
*   **Abas**: Conteúdo, Redes Sociais, Identidade Visual.
*   **Páginas**: Notícias, Avisos, Mídias do Culto.
*   **Ferramentas**: Agendamento de posts, Banco de mídia, Aprovação de conteúdo.
*   **Processos**: Comunicação institucional, Divulgação de eventos, Padronização visual.

#### 6.2. Módulo: Evangelismo
*   **Abas**: Ações, Equipes, Relatórios.
*   **Páginas**: Registro de Ações Evangelísticas, Cadastro de Evangelistas, Relatórios de Impacto.
*   **Ferramentas**: Planejamento de ações, Registro de testemunhos.
*   **Processos**: Evangelismo local, Acompanhamento de novos convertidos.

#### 6.3. Módulo: Missões
*   **Abas**: Missionários, Projetos, Sustento.
*   **Páginas**: Cadastro de Missionários, Projetos Missionários, Relatórios Missionários.
*   **Ferramentas**: Controle de apoio, Comunicação missionária.
*   **Processos**: Apoio missionário, Acompanhamento de projetos, Prestação de contas.

---

### 7️⃣ Gestão Financeira

#### 7.1. Agente: Tesouraria
*   **Tipo**: Sistema (ERP Financeiro) com Operador Humano
*   **Missão**: Registrar, controlar e prestar contas dos recursos financeiros.
*   **Responsabilidades**: Contas a pagar/receber, conciliação bancária, relatórios de dízimos, gestão de fluxo de caixa.
*   **Entradas**: Ofertas, notas fiscais de despesas.
*   **Saídas**: Balancetes mensais, comprovantes de pagamento.
*   **Integrações**: Conselho Fiscal, Contabilidade Externa.
*   **KPIs**: Precisão do fluxo de caixa, cumprimento do orçamento.
*   **Riscos**: Desvios, erros de lançamento.
*   **Ferramentas**: ERP Financeiro.
*   **Periodicidade**: Diária/Semanal.

#### 7.2. Agente: Conselho Fiscal
*   **Tipo**: Humano
*   **Missão**: Auditar e validar as contas da igreja.
*   **Responsabilidades**: Análise de balancetes, conferência de notas, parecer fiscal anual.
*   **Entradas**: Relatórios da tesouraria, extratos bancários.
*   **Saídas**: Parecer fiscal.
*   **Integrações**: Tesouraria, Assembléia de Membros.
*   **KPIs**: % de conformidade contábil.
*   **Riscos**: Responsabilidade civil.
*   **Ferramentas**: Planilhas de Auditoria.
*   **Periodicidade**: Trimestral/Semestral.

**Módulo de Software: Financeiro**
*   **Abas**: Entradas, Saídas, Orçamento, Relatórios.
*   **Páginas**: Registro de Contribuições, Contas a Pagar, Contas a Receber, Orçamento Anual, Prestação de Contas.
*   **Ferramentas**: Conciliação financeira, Relatórios contábeis, Exportação contábil.
*   **Processos**: Gestão financeira eclesiástica, Transparência, Controle orçamentário.

---

### 8️⃣ Patrimônio e Infraestrutura

#### 8.1. Agente: Zeladoria e Manutenção
*   **Tipo**: Humano / Terceirizado
*   **Missão**: Manter o templo limpo, seguro e funcionar.
*   **Responsabilidades**: Limpeza, manutenção preventiva, gestão de inventário de bens.
*   **Entradas**: Solicitações de reparo, cronograma de cultos.
*   **Saídas**: Templo pronto para uso.
*   **Integrações**: Eventos, Admin Geral.
*   **KPIs**: Tempo de resolução, estado de conservação.
*   **Riscos**: Depreciação acelerada.
*   **Ferramentas**: Checklist de Manutenção, Planilha de Inventário.
*   **Periodicidade**: Diária.

**Módulo de Software: Patrimônio e Infraestrutura**
*   **Abas**: Bens, Manutenção, Espaços.
*   **Páginas**: Inventário, Ordens de Serviço, Agenda de Uso.
*   **Ferramentas**: Controle patrimonial, Histórico de manutenção.
*   **Processos**: Conservação, Planejamento de uso, Manutenção preventiva.

---

### 9️⃣ Ação Social e Projetos

#### 9.1. Agente: Assistência Social
*   **Tipo**: Humano (Assistente Social + Voluntários)
*   **Missão**: Atender às necessidades materiais da comunidade e membros.
*   **Responsabilidades**: Triagem de famílias, distribuição de cestas básicas, cursos de capacitação.
*   **Entradas**: Pedidos de ajuda, doações.
*   **Saídas**: Famílias atendidas, relatórios sociais.
*   **Integrações**: Diaconia, Financeiro.
*   **KPIs**: Número de famílias assistidas.
*   **Riscos**: Assistencialismo sem transformação.
*   **Ferramentas**: Cadastro Único Social.
*   **Periodicidade**: Semanal.

**Módulo de Software: Ação Social / Diaconia**
*   **Abas**: Assistência, Voluntários, Doações.
*   **Páginas**: Cadastro de Assistidos, Projetos Sociais, Relatórios Sociais.
*   **Ferramentas**: Controle de atendimentos, Gestão de voluntários.
*   **Processos**: Atendimento social, Apoio comunitário, Prestação de contas.

---

### 🔟 Tecnologia da Informação

#### 10.1. Agente: Suporte e Infraestrutura de TI
*   **Tipo**: Humano ou Terceirizado
*   **Missão**: Garantir que todos os sistemas e equipamentos digitais funcionem.
*   **Responsabilidades**: Gestão da rede Wi-Fi, computadores, servidores, backups, segurança de dados (LGPD).
*   **Entradas**: Chamados de suporte, logs de sistema.
*   **Saídas**: Sistemas ativos (Uptime), dados seguros.
*   **Integrações**: Secretaria, Comunicação.
*   **KPIs**: Uptime, tempo de resposta.
*   **Riscos**: Ataques cibernéticos, perda de dados.
*   **Ferramentas**: Firewall, Antivírus, Backup em Nuvem.
*   **Periodicidade**: Monitoramento contínuo.

**Módulo de Software: Tecnologia da Informação**
*   **Abas**: Sistemas, Usuários, Segurança.
*   **Páginas**: Gestão de Acessos, Infraestrutura, Logs.
*   **Ferramentas**: Controle de permissões, Auditoria de sistema.
*   **Processos**: Suporte técnico, Segurança da informação, Manutenção do sistema.

---

### 1️⃣1️⃣ Jurídico, Compliance e Segurança

#### 11.1. Agente: Assessoria Jurídica
*   **Tipo**: Humano
*   **Missão**: Blindar a instituição juridicamente.
*   **Responsabilidades**: Análise de contratos, reforma estatutária, adequação à LGPD.
*   **Entradas**: Contratos, dúvidas legais.
*   **Saídas**: Contratos revisados, pareceres jurídicos.
*   **Integrações**: Diretoria Administrativa, RH.
*   **KPIs**: Zero processos procedentes.
*   **Riscos**: Passivo trabalhista.
*   **Ferramentas**: Jusbrasil, Softwares Jurídicos.
*   **Periodicidade**: Sob demanda.

**Módulo de Software: Jurídico / Compliance**
*   **Abas**: Documentos Legais, Obrigações, Conformidade.
*   **Páginas**: Estatuto, Atas, Certidões, LGPD.
*   **Ferramentas**: Alertas de vencimento, Controle documental.
*   **Processos**: Conformidade legal, Governança institucional, Proteção de dados.

---

### 1️⃣2️⃣ Eventos e Programação

#### 12.1. Agente: Gestão de Eventos
*   **Tipo**: Humano (Equipe de Produção)
*   **Missão**: Planejar e executar eventos memoráveis.
*   **Responsabilidades**: Criação do cronograma, logística, recepção.
*   **Entradas**: Calendário anual, orçamento.
*   **Saídas**: Evento realizado, relatório pós-evento.
*   **Integrações**: Todos os ministérios envolvidos.
*   **KPIs**: Satisfação, cumprimento do orçamento.
*   **Riscos**: Falhas logísticas.
*   **Ferramentas**: Run of Show, Checklists.
*   **Periodicidade**: Por evento.

**Módulo de Software: Eventos**
*   **Abas**: Planejamento, Execução, Avaliação.
*   **Páginas**: Agenda de Eventos, Cronogramas, Relatórios Pós-evento.
*   **Ferramentas**: Checklists, Gestão de equipes.
*   **Processos**: Organização, Execução, Avaliação final.

---

## 🔐 Modelo de Permissões

O sistema utiliza o modelo RBAC para garantir a segurança dos dados.

**Perfis de Usuário:**
- Pastor / Líder Geral
- Coordenador de Ministério
- Diretor Administrativo
- Financeiro
- Secretária
- Voluntário
- Usuário Comum

**Permissões baseadas em:**
- Área
- Página
- Ferramenta
- Ação (visualizar, criar, editar, aprovar)

---

## ✅ Resultado Esperado
- Igreja organizada
- Transparência administrativa
- Governança clara
- Apoio total à missão espiritual
- Base sólida para crescimento e expansão digital

---

## 🚀 Plano de Implantação

Roteiro prático para organizar a igreja do zero à maturidade.

### Fase 1: Fundação (O Essencial)
*   **Foco**: Legalidade e Controle Básico.
*   **Ações**:
    *   [ ] Constituir Estatuto e CNPJ.
    *   [ ] Abrir conta bancária PJ e iniciar controle financeiro.
    *   [ ] Implantar **Agente: Secretaria Geral** para cadastro básico de membros.
    *   [ ] Definir **Agente: Conselho Pastoral** e Visão inicial.

### Fase 2: Organização (Estruturação)
*   **Foco**: Processos e Pessoas.
*   **Ações**:
    *   [ ] Implantar sistema de gestão (CRM) para substituir planilhas.
    *   [ ] Estruturar **Agente: Tesouraria** com plano de contas definido.
    *   [ ] Organizar **Ministérios Básicos** (Louvor, Infantil, Recepção) com líderes definidos.
    *   [ ] Iniciar **Agente: Hub de Comunicação** (Redes sociais básicas).

### Fase 3: Automação (Eficiência)
*   **Foco**: Ganho de Tempo e Escala.
*   **Ações**:
    *   [ ] Integrar site/app ao CRM (Inscrições online, dízimo online).
    *   [ ] Automatizar comunicação (Régua de e-mails para visitantes/aniversariantes).
    *   [ ] Implantar **Agente: Suporte de TI** para garantir segurança de dados e backups automáticos.
    *   [ ] Padronizar escalas de voluntários via App.

### Fase 4: Maturidade (Excelência e Expansão)
*   **Foco**: Dados, Qualidade e Multiplicação.
*   **Ações**:
    *   [ ] Implantar **Conselho Fiscal** ativo e auditorias regulares.
    *   [ ] Utilizar KPIs para tomada de decisão.
    *   [ ] Estruturar **Agente: Ação Social** com projetos robustos.
    *   [ ] Preparar liderança para plantação de novas igrejas ou novos cultos.

---

## 📋 TAREFAS PENDENTES PARA CONCLUSÃO DO SISTEMA

### 🎯 Status Atual: 85% Completo

#### 🚨 **Módulos Críticos Faltantes (15%)**

**1. COMUNICAÇÃO E MÍDIA - 20% FALTANTE**

**Controllers Faltantes:**
- [ ] `MediaController.php` - Upload/gerenciamento de arquivos mídia
- [ ] `MediaPlaylistController.php` - Criação de playlists de vídeos/áudios
- [ ] `MediaCategoryController.php` - Categorias de mídia (cultos, eventos, pregações)
- [ ] `LiveStreamController.php` - Controle de transmissões ao vivo

**Models Faltantes:**
- [ ] `Media.php` - Armazenar informações de arquivos (título, descrição, tipo, tamanho)
- [ ] `MediaCategory.php` - Categorias organizacionais
- [ ] `MediaPlaylist.php` - Playlists organizadas
- [ ] `LiveStream.php` - Configurações de transmissão

**Migrations Faltantes:**
- [ ] `create_medias_table.php` - id, title, description, file_path, file_type, file_size, duration, media_category_id, created_at
- [ ] `create_media_categories_table.php` - id, name, description, color, icon
- [ ] `create_media_playlists_table.php` - id, name, description, is_active
- [ ] `create_media_playlist_items_table.php` - id, media_playlist_id, media_id, order
- [ ] `create_live_streams_table.php` - id, title, description, stream_key, platform, scheduled_at, ended_at

**Views Faltantes:**
- [ ] `/resources/views/admin/media/index.blade.php` - Listagem geral de mídias
- [ ] `/resources/views/admin/media/create.blade.php` - Form upload
- [ ] `/resources/views/admin/media/show.blade.php` - Player de vídeo/áudio
- [ ] `/resources/views/admin/media/categories/index.blade.php` - Gestão de categorias
- [ ] `/resources/views/admin/media/playlists/index.blade.php` - Gestão de playlists
- [ ] `/resources/views/admin/media/livestreams/index.blade.php` - Controle de transmissões

**Features Faltantes:**
- [ ] Upload de múltiplos arquivos (drag & drop)
- [ ] Processamento automático de vídeos (compressão)
- [ ] Extração automática de thumbnail
- [ ] Player integrado com controles de velocidade
- [ ] Sistema de busca avançada por título/descrição
- [ ] Agendamento de publicação automática
- [ ] Integração com YouTube/Facebook para streaming
- [ ] Relatórios de visualização/métricas

**2. LOUVOR E ADORAÇÃO - 15% FALTANTE**

**Controllers Faltantes:**
- [ ] `WorshipSongController.php` - CRUD de músicas
- [ ] `WorshipSetlistController.php` - Listas de músicas por culto
- [ ] `WorshipTeamController.php` - Gestão de equipes de louvor
- [ ] `WorshipRehearsalController.php` - Controle de ensaios

**Models Faltantes:**
- [ ] `WorshipSong.php` - Informações da música (título, artista, tom, letra, cifra)
- [ ] `WorshipSetlist.php` - Lista de músicas para culto específico
- [ ] `WorshipSetlistItem.php` - Itens da setlist (música + ordem)
- [ ] `WorshipTeam.php` - Equipes de ministério
- [ ] `WorshipRehearsal.php` - Agendamento de ensaios

**Migrations Faltantes:**
- [ ] `create_worship_songs_table.php` - id, title, artist, key, bpm, duration, lyrics, chords, is_active
- [ ] `create_worship_setlists_table.php` - id, church_event_id, date, theme, notes
- [ ] `create_worship_setlist_items_table.php` - id, worship_setlist_id, worship_song_id, order, notes
- [ ] `create_worship_teams_table.php` - id, name, description, leader_id, is_active
- [ ] `create_worship_rehearsals_table.php` - id, worship_team_id, scheduled_at, location, notes

**Views Faltantes:**
- [ ] `/resources/views/admin/worship/songs/index.blade.php` - Listagem de músicas
- [ ] `/resources/views/admin/worship/songs/create.blade.php` - Cadastro de música
- [ ] `/resources/views/admin/worship/songs/show.blade.php` - Visualização com letra/cifra
- [ ] `/resources/views/admin/worship/setlists/index.blade.php` - Histórico de setlists
- [ ] `/resources/views/admin/worship/setlists/create.blade.php` - Criar setlist
- [ ] `/resources/views/admin/worship/teams/index.blade.php` - Gestão de equipes
- [ ] `/resources/views/admin/worship/rehearsals/index.blade.php` - Agenda de ensaios

**Features Faltantes:**
- [ ] Importação de cifras automaticamente (API externa)
- [ ] Transposição automática de tom
- [ ] Geração de PDF com cifras
- [ ] Histórico de músicas mais utilizadas
- [ ] Sistema de busca por título/artista/tema
- [ ] Integração com planejamento de culto
- [ ] Controle de disponibilidade de músicos
- [ ] Relatórios de frequência de ensaios

**3. EVENTOS - 15% FALTANTE**

**Controllers Faltantes:**
- [ ] `EventChecklistController.php` - Checklists para eventos
- [ ] `EventEvaluationController.php` - Avaliação pós-evento
- [ ] `EventTaskController.php` - Gestão de tarefas do evento
- [ ] `EventResourceController.php` - Gestão de recursos (equipamentos)

**Models Faltantes:**
- [ ] `EventChecklist.php` - Modelos de checklist
- [ ] `EventChecklistItem.php` - Itens do checklist
- [ ] `EventChecklistExecution.php` - Execução do checklist
- [ ] `EventEvaluation.php` - Formulários de avaliação
- [ ] `EventEvaluationResponse.php` - Respostas das avaliações
- [ ] `EventTask.php` - Tarefas específicas do evento
- [ ] `EventResource.php` - Recursos necessários

**Migrations Faltantes:**
- [ ] `create_event_checklists_table.php` - id, name, description, event_type_id
- [ ] `create_event_checklist_items_table.php` - id, event_checklist_id, description, is_required, order
- [ ] `create_event_checklist_executions_table.php` - id, church_event_id, event_checklist_id, executed_by, completed_at
- [ ] `create_event_checklist_item_executions_table.php` - id, execution_id, item_id, is_completed, notes
- [ ] `create_event_evaluations_table.php` - id, church_event_id, title, questions
- [ ] `create_event_evaluation_responses_table.php` - id, evaluation_id, user_id, responses
- [ ] `create_event_tasks_table.php` - id, church_event_id, title, description, assigned_to, due_date, status
- [ ] `create_event_resources_table.php` - id, name, type, quantity, location

**Views Faltantes:**
- [ ] `/resources/views/admin/events/checklists/index.blade.php` - Modelos de checklist
- [ ] `/resources/views/admin/events/checklists/execute.blade.php` - Execução de checklist
- [ ] `/resources/views/admin/events/evaluations/index.blade.php` - Histórico de avaliações
- [ ] `/resources/views/admin/events/evaluations/create.blade.php` - Criar avaliação
- [ ] `/resources/views/admin/events/evaluations/respond.blade.php` - Formulário de resposta
- [ ] `/resources/views/admin/events/tasks/index.blade.php` - Gestão de tarefas
- [ ] `/resources/views/admin/events/resources/index.blade.php` - Gestão de recursos

**Features Faltantes:**
- [ ] Run of Show automatizado com timeline
- [ ] Checklists personalizáveis por tipo de evento
- [ ] Sistema de atribuição automática de tarefas
- [ ] Notificações de pendências
- [ ] Formulários de feedback com métricas
- [ ] Relatórios de satisfação pós-evento
- [ ] Controle de recursos e equipamentos
- [ ] Timeline visual do evento

**4. ADMINISTRAÇÃO GERAL - 5% FALTANTE**

**Controllers Faltantes:**
- [ ] `MeetingMinutesController.php` - Gestão de atas de reunião
- [ ] `MeetingController.php` - Agendamento de reuniões
- [ ] `OfficialDocumentController.php` - Documentos oficiais (estatuto, regimento)

**Models Faltantes:**
- [ ] `Meeting.php` - Informações da reunião
- [ ] `MeetingMinutes.php` - Ata da reunião
- [ ] `MeetingParticipant.php` - Participantes
- [ ] `OfficialDocument.php` - Documentos institucionais

**Migrations Faltantes:**
- [ ] `create_meetings_table.php` - id, title, description, scheduled_at, location, meeting_type
- [ ] `create_meeting_minutes_table.php` - id, meeting_id, content, approved_by, approved_at
- [ ] `create_meeting_participants_table.php` - id, meeting_id, user_id, role, attended
- [ ] `create_official_documents_table.php` - id, title, content, document_type, approved_at, version

**Views Faltantes:**
- [ ] `/resources/views/admin/meetings/index.blade.php` - Lista de reuniões
- [ ] `/resources/views/admin/meetings/create.blade.php` - Agendar reunião
- [ ] `/resources/views/admin/meetings/minutes/index.blade.php` - Histórico de atas
- [ ] `/resources/views/admin/meetings/minutes/create.blade.php` - Redigir ata
- [ ] `/resources/views/admin/documents/official/index.blade.php` - Documentos oficiais

**Features Faltantes:**
- [ ] Geração automática de atas a partir de gravações
- [ ] Sistema de aprovação de atas
- [ ] Histórico de decisões tomadas
- [ ] Controle de versão de documentos
- [ ] Assinatura digital de documentos
- [ ] Alertas de reuniões agendadas

**5. FINANCEIRO - 5% FALTANTE**

**Controllers Faltantes:**
- [ ] `BankIntegrationController.php` - Integração bancária
- [ ] `BankReconciliationController.php` - Conciliação bancária
- [ ] `FinancialReportController.php` - Relatórios financeiros avançados

**Models Faltantes:**
- [ ] `BankAccount.php` - Contas bancárias
- [ ] `BankTransaction.php` - Transações bancárias
- [ ] `BankReconciliation.php` - Conciliação
- [ ] `FinancialReport.php` - Relatórios gerados

**Migrations Faltantes:**
- [ ] `create_bank_accounts_table.php` - id, bank_name, agency, account_number, account_type
- [ ] `create_bank_transactions_table.php` - id, bank_account_id, date, description, amount, type
- [ ] `create_bank_reconciliations_table.php` - id, bank_account_id, reconciliation_date, status
- [ ] `create_financial_reports_table.php` - id, title, content, report_type, generated_at

**Views Faltantes:**
- [ ] `/resources/views/admin/finance/bank/index.blade.php` - Contas bancárias
- [ ] `/resources/views/admin/finance/bank/reconciliation.blade.php` - Conciliação
- [ ] `/resources/views/admin/finance/reports/index.blade.php` - Relatórios financeiros

**Features Faltantes:**
- [ ] Importação automática de extratos bancários
- [ ] Conciliação bancária inteligente
- [ ] Relatórios DRE completo
- [ ] Projeções de fluxo de caixa
- [ ] Análise de tendências financeiras

**6. RELATÓRIOS E DASHBOARDS - 30% FALTANTE**

**Controllers Faltantes:**
- [ ] `ReportController.php` - Central de relatórios
- [ ] `DashboardController.php` - Dashboards personalizados
- [ ] `AnalyticsController.php` - Análise de dados
- [ ] `KpiController.php` - Indicadores chave

**Models Faltantes:**
- [ ] `Report.php` - Configurações de relatórios
- [ ] `Dashboard.php` - Configurações de dashboard
- [ ] `Kpi.php` - Indicadores de performance
- [ ] `AnalyticsEvent.php` - Eventos para analytics

**Migrations Faltantes:**
- [ ] `create_reports_table.php` - id, title, description, query, parameters, is_active
- [ ] `create_dashboards_table.php` - id, name, description, layout, user_id
- [ ] `create_kpis_table.php` - id, name, description, calculation_method, target, current_value
- [ ] `create_analytics_events_table.php` - id, event_type, user_id, data, created_at

**Views Faltantes:**
- [ ] `/resources/views/admin/reports/index.blade.php` - Central de relatórios
- [ ] `/resources/views/admin/reports/create.blade.php` - Criar relatório
- [ ] `/resources/views/admin/dashboards/index.blade.php` - Lista de dashboards
- [ ] `/resources/views/admin/dashboards/show.blade.php` - Visualização do dashboard
- [ ] `/resources/views/admin/analytics/index.blade.php` - Analytics geral

**Features Faltantes:**
- [ ] Dashboard pastoral com métricas espirituais
- [ ] Relatórios de crescimento mensal automático
- [ ] Análise de engajamento ministerial
- [ ] KPIs personalizáveis por ministério
- [ ] Gráficos interativos com filtros
- [ ] Exportação em PDF/Excel
- [ ] Agendamento de relatórios automáticos
- [ ] Comparativos históricos

**7. NOTIFICAÇÕES E ALERTAS - 25% FALTANTE**

**Controllers Faltantes:**
- [ ] `NotificationController.php` - Gestão de notificações
- [ ] `NotificationTemplateController.php` - Templates de notificação
- [ ] `AlertController.php` - Sistema de alertas
- [ ] `ReminderController.php` - Lembretes automáticos

**Models Faltantes:**
- [ ] `Notification.php` - Notificações enviadas
- [ ] `NotificationTemplate.php` - Templates padronizados
- [ ] `Alert.php` - Alertas configurados
- [ ] `Reminder.php` - Lembretes agendados

**Migrations Faltantes:**
- [ ] `create_notifications_table.php` - id, user_id, title, message, type, read_at
- [ ] `create_notification_templates_table.php` - id, title, content, template_type, variables
- [ ] `create_alerts_table.php` - id, title, condition, action, is_active
- [ ] `create_reminders_table.php` - id, user_id, title, message, scheduled_at, sent_at

**Views Faltantes:**
- [ ] `/resources/views/admin/notifications/index.blade.php` - Histórico de notificações
- [ ] `/resources/views/admin/notifications/templates/index.blade.php` - Templates
- [ ] `/resources/views/admin/alerts/index.blade.php` - Configuração de alertas
- [ ] `/resources/views/admin/reminders/index.blade.php` - Gestão de lembretes

**Features Faltantes:**
- [ ] Sistema de notificações push/email/SMS
- [ ] Alertas de aniversariantes automáticos
- [ ] Lembretes automáticos de tarefas
- [ ] Notificações por permissão/role
- [ ] Histórico de comunicações
- [ ] Taxas de entrega e abertura
- [ ] Personalização por usuário/ministério

**8. API PÚBLICA - 40% FALTANTE**

**Controllers Faltantes:**
- [ ] `Api/V1/AuthController.php` - Autenticação via API
- [ ] `Api/V1/MemberController.php` - CRUD de membros via API
- [ ] `Api/V1/EventController.php` - Gestão de eventos via API
- [ ] `Api/V1/DonationController.php` - Doações via API
- [ ] `Api/V1/NotificationController.php` - Notificações via API

**Middleware Faltantes:**
- [ ] `ApiAuthMiddleware.php` - Validação de tokens
- [ ] `ApiRateLimitMiddleware.php` - Controle de rate limit
- [ ] `ApiCorsMiddleware.php` - Configuração CORS

**Models Faltantes:**
- [ ] `ApiToken.php` - Tokens de acesso à API
- [ ] `ApiLog.php` - Logs de requisições à API
- [ ] `ApiUsage.php` - Estatísticas de uso

**Migrations Faltantes:**
- [ ] `create_api_tokens_table.php` - id, user_id, token, permissions, expires_at
- [ ] `create_api_logs_table.php` - id, endpoint, method, user_id, response_code, response_time
- [ ] `create_api_usage_table.php` - id, date, endpoint, requests_count

**Routes Faltantes:**
- [ ] `/routes/api/v1/auth.php` - Autenticação
- [ ] `/routes/api/v1/members.php` - Membros
- [ ] `/routes/api/v1/events.php` - Eventos
- [ ] `/routes/api/v1/donations.php` - Doações
- [ ] `/routes/api/v1/notifications.php` - Notificações

**Features Faltantes:**
- [ ] Endpoints RESTful completos
- [ ] Autenticação via OAuth2/Bearer tokens
- [ ] Rate limiting por usuário
- [ ] Documentação OpenAPI/Swagger
- [ ] Versionamento da API
- [ ] Webhooks para integrações
- [ ] Sandbox para testes
- [ ] Monitoramento de uso da API

---

## 🤖 **PROMPT PARA AGENTE IMPLEMENTADOR**

```
Você é o AGENT_ARCHITECT_DATA e sua missão é completar os módulos faltantes do sistema CRM da igreja.

## TAREFAS ESPECÍFICAS:

1. **MÓDULO DE COMUNICAÇÃO E MÍDIA (20% FALTANTE)**
   - Criar MediaController para upload de vídeos/áudios/imagens
   - Implementar Model Media com categorias
   - Criar views para galeria e player de mídia
   - Adicionar agendamento automático de posts
   - Implementar banco de mídia organizado

2. **MÓDULO DE LOUVOR (15% FALTANTE)**
   - Criar WorshipSongController para repertório
   - Implementar Models: WorshipSong, WorshipSetlist
   - Criar views para gestão de repertório musical
   - Adicionar histórico de músicas por culto
   - Integrar com planejamento de cultos

3. **MÓDULO DE EVENTOS (15% FALTANTE)**
   - Criar EventChecklistController e EventEvaluationController
   - Implementar Models: EventChecklist, EventEvaluation
   - Criar views para checklists e avaliações
   - Adicionar Run of Show automatizado
   - Implementar formulários de feedback

4. **MÓDULO DE RELATÓRIOS (30% FALTANTE)**
   - Criar ReportController com KPIs ministeriais
   - Implementar DashboardController com analytics
   - Criar views para relatórios de crescimento
   - Adicionar análise de engajamento
   - Implementar métricas espirituais

5. **MÓDULO DE NOTIFICAÇÕES (25% FALTANTE)**
   - Criar NotificationController para alertas
   - Implementar Models: Notification, NotificationTemplate
   - Criar sistema de notificações push/email
   - Adicionar alertas de aniversariantes
   - Implementar lembretes automáticos

6. **API PÚBLICA (40% FALTANTE)**
   - Criar ApiController com endpoints REST
   - Implementar routes /api/v1/ para mobile
   - Adicionar autenticação via tokens
   - Criar endpoints para inscrições e doações
   - Implementar consulta de membros

## REQUISITOS:
- Seguir padrão Laravel 12 + AdminLTE 4
- Implementar RBAC em cada módulo
- Criar migrations, models, controllers, views
- Adicionar validações e segurança
- Manter organização por prefixo de rota
- Usar Bootstrap 5 para UI
- Implementar logs de auditoria

## ORDEM DE EXECUÇÃO:
1. Comunicação e Mídia
2. Louvor e Adoração  
3. Eventos e Checklists
4. Relatórios e Dashboards
5. Notificações e Alertas
6. API Pública

Execute cada módulo completamente antes de passar para o próximo.
```
