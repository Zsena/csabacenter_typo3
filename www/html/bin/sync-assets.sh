#!/bin/bash

usage()
{
    echo "Sync assets with target environment"
    echo "Usage: sync-assets -s|--source staging|production -t|--target dev|staging|production [-d|--delete]"
    echo "-s --source Source environment"
    echo "-t --target Target environment"
    echo "-d --delete Delete files which are not present anymore on target environment"
}

while [ "$1" != "" ]; do
  case $1 in
    -s | --source )    shift
                       source=$1
                       ;;
    -t | --target )    shift
                       target=$1
                       ;;
    -d | --delete )    shift
                       delete="--delete"
                       ;;
    -h | --help )      usage
                       exit
                       ;;
    * )                usage
                       exit 1
  esac
  shift
done

if [ "$source" == "staging" -o "$source" == "production" ]; then
  if [ "$target" == "dev" -o "$target" == "staging" -o "$target" == "production" ]; then
    case $target in
          "dev")
            path=~/html/public
          ;;
          "staging")
            path=~/v9/stage/shared/public
          ;;
          "production")
            path=~/v9/live/shared/public
          ;;
        esac

    if [ -z "$delete" ]; then
      echo "rsync -avhz $source:$sourcepath $path"

      case $source in
        "dev")
          rsync -avhz "$source":~/html/public/fileadmin $path
        ;;
        "staging")
          rsync -avhz "$source":~/clickandbuilds/csabacenter/stage/shared/public/fileadmin $path
        ;;
        "production")
          rsync -avhz "$source":~/clickandbuilds/csabacenter/live/shared/public/fileadmin $path
        ;;
      esac
    else
        case $source in
          "dev")
            rsync -avhz "$delete" "$source":~/html/public/fileadmin $path
          ;;
          "staging")
            rsync -avhz "$delete" "$source":~/clickandbuilds/csabacenter/stage/shared/public/fileadmin $path
          ;;
          "production")
            rsync -avhz "$delete" "$source":~/clickandbuilds/csabacenter/live/shared/public/fileadmin $path
          ;;
        esac
    fi
  else
    usage
  fi
else
  usage
fi
