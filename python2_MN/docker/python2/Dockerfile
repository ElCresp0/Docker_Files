###################################################################################################
# Select a base image (possibility of using custom base images)
# Build from the MATLAB base image
# The MATLAB images are based on ubuntu
FROM mathworks/matlab:r2023a
###################################################################################################


###################################################################################################
# install python with apt-get, these RUN instructions get cached
# so they take time only on the first build
RUN sudo apt-get update && sudo apt-get install -y python3.9 libpython3.9-dev
###################################################################################################

###################################################################################################
# copy files from working directory to the container
# COPY requirements.txt requirements.txt
COPY test.py test.py
COPY license.lic license.lic
###################################################################################################


###################################################################################################
# pip install -r requirements.txt is a good practice, you can set up virtual environments
# in the container as well
# RUN python3.9 -m pip install -r requirements.txt
# 
# RUN python3.9 -m pip install matplotlib && \
#     python3.9 -m pip install numpy && \
#     python3.9 -m pip install pandas
###################################################################################################


###################################################################################################
# INSTALL THE MATLAB ENGINE FOR PYTHON
RUN cd /opt/matlab/R2023a/extern/engines/python && \
    sudo python3.9 setup.py install
# RUN cd /opt/matlab/R2023a/extern/engines/python && \
#     python3.9 -m pip install .
# RUN export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/opt/matlab/R2023a/bin/glnxa64 && \
#     python3.9 -m pip install matlabengine
###################################################################################################


###################################################################################################
# INSTALL THE MATLAB ENGINE FOR PYTHON from within a matlab script
# COPY myscript.m myscript.m
# RUN matlab myscript
###################################################################################################


###################################################################################################
# what happens when you run the container
# CMD ["matlab"]
# CMD ["python3.9", "test.py"]
# CMD ["which", "python3.9"]
# CMD ["python3.9"]
CMD ["bash"]
# CMD ["ls", "-R", "/usr/local/bin/matlab"]
###################################################################################################


###################################################################################################
# instructions:
# $ docker build -t my-matlab-container .  
# $ docker run -it --rm -e MLM_LICENSE_FILE=license.lic --shm-size=512M my-matlab-container
# my-matlab-container $ python3.9 test.py
###################################################################################################

# https://www.mathworks.com/matlabcentral/answers/879598-matlab-engine-engineerror-unable-to-launch-simple-server-unable-to-launch-opt-matlab-r2020b-bin-m