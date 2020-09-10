#!/bin/bash

usage()
{
    echo "Sync database with target environment"
    echo "Usage: sync-db -s|--source staging|production -t|--target dev|staging|production"
    echo "-s --source Source environment"
    echo "-t --target Target environment"
}

while [ "$1" != "" ]; do
  case $1 in
    -s | --source )  shift
                     source=$1
                     ;;
    -t | --target )  shift
                     target=$1
                     ;;
    -h | --help )    usage
                     exit
                     ;;
    * )              usage
                     exit 1
  esac
  shift
done

if [ "$source" == "staging" -o "$source" == "production" ]; then
  if [ "$source" == "staging" ]; then
    context="TYPO3_CONTEXT=Production/Staging"
  else
    context="TYPO3_CONTEXT=Production/Live"
  fi

  if [ "$target" == "dev" -o "$target" == "staging" -o "$target" == "production" ]; then
    case $target in
      "dev")
        path=~/html/vendor/bin/typo3cms
      ;;
      "staging")
        path=~/clickandbuilds/csabacenter/stage/current/vendor/bin/typo3cms
      ;;
      "production")
        path=~/clickandbuilds/csabacenter/live/current/vendor/bin/typo3cms
      ;;
    esac

    case $source in
      "staging")
        context="TYPO3_CONTEXT=Production/Staging"
        ssh $source "$context ~/clickandbuilds/csabacenter/stage/current/vendor/bin/typo3cms database:export -e 'be_sessions' -e 'cache_treelist' -e 'cf_*' -e 'fe_sessions' -e 'sys_history' -e 'sys_log' -e 'tx_solr_*'" | $path database:import
      ;;
      "production")
        context="TYPO3_CONTEXT=Production/Live"
        ssh $source "$context ~/clickandbuilds/csabacenter/live/current/vendor/bin/typo3cms database:export -e 'be_sessions' -e 'cache_treelist' -e 'cf_*' -e 'fe_sessions' -e 'sys_history' -e 'sys_log' -e 'tx_solr_*'" | $path database:import
    esac

    $path database:updateschema
  else
    usage
  fi
else
  usage
fi
