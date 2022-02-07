## [0.5.1] - 2022-02-07

- Disable auto-updates by default. WordPress updates should be managed by the
  chart and rolled out when the chart is updated. It is still possible to
  enable auto-updates by editing the `.Values.wordpress.updates` variables.
- Disable editing WordPress files by default. This can be undone by setting the
  `.Values.wordpress.disallow_file_edit` variable to `false`.

## [0.5.0] - 2022-02-04

- Plugins overhaul
  - You can now specify plugins under `.Values.wordpress.plugins`. You can
    specify a slug of a WordPress.org plugin, or an URL to a zip file containing
    a plugin. Examples are shown in `values-local.yaml.example`
  - You now need to specify mu-plugins as a list. see
    `values-local.yaml.example` for examples. Some improvements have been made
    too, like you don't have to enable mu_cron in order to be able to use
    mu_plugins
- Fine-grained control over debug functionality
  - The boolean for the `WP_DEBUG` config variable has moved from
    `.Values.wordpress.site.debug` to `.Values.wordpress.site.debug.enabled`.
  - Two fields `.Values.wordpress.site.debug.display` and
    `.Values.wordpress.site.debug.log` have been added that can be set to `true`
    or `false` to control `WP_DEBUG_DISPLAY` and `WP_DEBUG_LOG` respectively.

## [0.4.9] - 2021-01-27

- Update Docker containers to:
  - php:8.1.2-apache-bullseye
  - wordpress:cli-2.6.0-php8.1

## [0.4.8] - 2021-01-26

- Update Redis chart to v16.1.1

## [0.4.7] - 2021-01-21

- Update Redis chart to v16.0.0

## [0.4.6] - 2021-01-21

- Update Mariadb chart to v10.3.2

## [0.4.5] - 2021-01-13

- Update Redis chart to v15.7.5

## [0.4.4] - 2021-12-20

* Update PHP to 8.1.1

## [0.4.3] - 2021-12-07

* Release helm chart on GL helmrepository
* Upgrade Mariadb helm chart to 10.1.0
* Upgrade Redis helm chart to 15.6.3
* Upgrade default WordPress version to 5.8.2
* Use PHP 8.1

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
