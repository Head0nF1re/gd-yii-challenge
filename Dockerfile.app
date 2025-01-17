FROM yiisoftware/yii2-php:8.4-apache

ARG USERNAME=gd
ARG USER_UID=1000
ARG USER_GID=33

RUN useradd --uid $USER_UID --gid $USER_GID -m $USERNAME 
USER $USERNAME
