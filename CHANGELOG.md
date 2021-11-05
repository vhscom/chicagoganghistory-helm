## [0.4.2] - 2021-11-05

* Moved repository to open.greenhost.net/stackspin/wordpress-helm because the
  OpenAppStack project got renamed to Stackspin

## [0.4.1] - 2021-10-26

* Add SMTP settings
* Update to stable ingress API
* Update charts:
  * Mariadb to 9.6.4
  * PHP docker to 8.0.4
  * redis to 15.5.1

## [0.4.0] - 2021-10-20

* Update redis chart to version 15
  * BREAKING: This needs a re-install of the Redis release (this should be OK
    because redis is only for caching). This also needs you to move the
    following variables: 
    - `redis.password` is now `redis.auth.password`
    - `redis.cluster.enabled` is now `redis.architecture`, which takes values
      "standalone" and "replication" (this chart defaults to standalone).
    - See [the Redis chart upgrade guide](https://github.com/bitnami/charts/tree/master/bitnami/redis#upgrading)
      for other changes
* Update default WordPress version to 5.8.1
* Update MariaDB chart version to 9.6.2

## [0.3.1] - 2021-09-30

* Fix database service name for standalone architecture

## [0.3.0] - 2021-09-28

* Cron overhaul:
  - Change the sidecar container to run a cron daemon instead of the backup
    script with manual sleep.
  - Put the backup script in a crontab.
  - Remove the kubernetes CronJob that did the wordpress cron calling,
    replacing it by a regular cronjob.
  - Allow custom crontab entries, provided from a helm value.
* Update mariadb chart to 9.6.0
  NOTE: the mariadb chart does not provide backwards compatibility in this
  case, so manual action is required if you want to upgrade an existing
  wordpress-helm release to this new version: either by migrating database data
  from the old release to the new one, or by using the `existingClaim`
  parameter(s) to reuse the existing persistent volumes. For details, see
  [mariadb chart upgrade notes](
  https://artifacthub.io/packages/helm/bitnami/mariadb/9.6.0#to-8-0-0)

## [0.2.2] - 2021-09-22

* Remove duplicate key `checksum/config` from template

## [0.2.1] - 2021-09-16

* Allow setting custom labels on pods and statefulset

## [0.2.0] - 2021-05-25

* Update Chart to apiVersion 2, move requirements to Chart.yaml
  NOTE: This means Helm 3 is required to install and maintain the chart

## [0.1.8] - 2021-06-14

* Set image pull policy for cronjob image to IfNotPresent to prevent problems
  with Docker rate limits

## [0.1.7] - 2021-05-12

* Add numberic based backup option that uses number-based backup scheme instead
  of date-based. With this, you can save 1 monthly backup and two weekly backups
  prepended with "A" and "B"

## [0.1.6] - 2021-01-14

* Improve how `WP_CRON_CONTROL_SECRET` works / make sure `helm install` works with default values
* Add support for parent and child themes
* Only spawn cronjobs if the WordPress pod is ready
* Update database in Ansible playbook
* Allow extra arguments to `install.sh` scripts
* Fix rights issue with `config.php` that caused restarted pods to fail
* Squelch "Cannot set fs attributes on a non-existent symlink target" message

## [0.1.5] - 2020-09-23

* Re-enable some redis commands disabled by Bitnami by default
* Harden WordPress default file and directory permissions
* Show external IP in `kubectl logs` output by using mod_remoteip
* Add Kubernetes CronJob for running Cron-control jobs
* Rsync backups to remote storage
* Make `enableServicesLink` flag configurable so services can be hidden from devs
* Use `us_en` locale by default to prevent problems with new wordpress releases
* Set max upload size to 50m
* Add custom php.ini
* Fix MU_PLUGIN_DIR path
* Bump default WordPress version to 5.4.2

## [0.1.4] - 2020-07-08

* Use PodSecurityContext instead of container security contexts
* If enabled, merge roles from OIDC server into OIDC accounts

## [0.1.3] - 2020-06-18

* Only set imagePullSecrets if the corresponding helm value is set.
* Run apache as non-root user, and listen on port 8080 inside the docker
  container.

## [0.1.2] - 2020-06-09

* Moved repository to open.greenhost.net/openappstack/wordpress-helm
* Removed `*_enabled` tags from config
* Removed `with_items` elements from ansible playbook
