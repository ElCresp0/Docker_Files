# SETUP
$ docker build -t my-matlab-container .
save a matlab license file in the directory of the dockerfile
^ to generate the license, a MAC address of the image is going to be needed, run the image in order to obtain it
$ docker run -it --rm -e MLM_LICENSE_FILE=license.lic --shm-size=512M my-matlab-container
my-matlab-container $ python3.9 test.py

# RESULTS
    a docker image with:
    - matlab engine
    - specified python version

# HERE INSERT DIFFERENCES BETWEEN: docker image, docker container, virtual machine
mainly: several containers can run on a shared kernel; containers provide better automation and portability

# SOURCES
https://hub.docker.com/r/mathworks/matlab
https://www.mathworks.com/help/matlab/matlab-engine-for-python.html
https://stackoverflow.com/questions/59681129/setting-specific-python-version-in-docker-file-with-specfic-non-python-base-imag