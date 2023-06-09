# SETUP
```
$ docker build -t my-matlab-container .
```
save a matlab license file in the directory of the dockerfile

^ to generate the license, a MAC address of the container is going to be needed, run the container in order to obtain it.

The -rm parameter below tells docker to delete the container immediately after stopping it,

the -it parameter instructs docker to run a container in an interactive mode
```
$ docker run -it --rm -e MLM_LICENSE_FILE=license.lic --shm-size=512M my-matlab-container
```
And once the container is running, run
```
my-matlab-container $ python3.9 test.py
```
to test whether the matlab and python work correctly.

# RESULTS
a docker image with:
- matlab engine
- specified python version

# why not simply venv
While python virtual environments share some use cases with docker containers, the former are mainly a development tool, while the latter remain more portable and thus are used as means of development, testing and deployment.

# SOURCES
https://hub.docker.com/r/mathworks/matlab
https://www.mathworks.com/help/matlab/matlab-engine-for-python.html
https://stackoverflow.com/questions/59681129/setting-specific-python-version-in-docker-file-with-specfic-non-python-base-imag
https://circleci.com/blog/docker-image-vs-container/#c-consent-modal