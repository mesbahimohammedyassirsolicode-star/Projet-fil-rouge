---
trigger: always_on
---

# Protocoles d'Interaction

## Objectif

Définir les protocoles fondamentaux d'interaction avec l'agent, incluant les modes de conversation, la gestion des workflows.

## Instructions

### 1. Modes d'Interaction (Préfixe de Commande)

- **Mode Discussion (`>`)** :
  - Analyser les requêtes commençant par `>` comme des demandes d'analyse uniquement.
  - Répondre par le chat sans modifier, créer ou supprimer de fichiers.
  - Fournir des explications pédagogiques et des analyses techniques.

- **Mode Standard (Aucun Préfixe)** :
  - Appliquer le comportement normal de l'agent.
  - Permettre la discussion et les actions sur le projet.

### 2. Gestion des Workflows

- **Identifier** le workflow pertinent pour chaque tâche demandée (ex: `/init-lab`, `/impl-feature`).

#### Traçabilité des Exécutions (Obligatoire)

**À la fin de chaque réponse**, afficher la traçabilité complète selon le template suivant :

**Template Standard** :
```
---

Workflow utilisé : /[nom-workflow]
Action exécutée : [Action X] - [Description de l'action] (Skill: [nom-skill])
```

## Interdictions
- **INTERDICTION** de modifier, créer ou supprimer des fichiers en Mode Discussion (`>`).
- **INTERDICTION** d'exécuter des commandes système en Mode Discussion (`>`).
- **INTERDICTION** de traiter spontanément les commentaires `TODO :` sans directive explicite.