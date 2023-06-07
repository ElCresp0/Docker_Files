# Docker_Files
Project for purposes of Advanced Computer Architectures course. It contains an overview of functionalities provided by Docker.

# Raport

## Jak się chronić - dobre praktyki bezpieczeństwa w dockerze:

1.Minimalizacja obrazów Docker: Im mniej pakietów i usług w kontenerze, tym mniej potencjalnych wejść dla atakującego. Stwórz kontenery tylko z tym, co naprawdę jest potrzebne dla twojej aplikacji.

2.Nie używaj konta root: Jeżeli to możliwe, unikaj uruchamiania procesów jako root w kontenerze. Zamiast tego, twórz i używaj innych użytkowników.

3.Aktualizuj obrazy Docker: Regularnie aktualizuj swoje obrazy Docker, aby mieć najnowsze poprawki bezpieczeństwa.

4.Używaj mechanizmów izolacji: Docker i inne technologie konteneryzacji oferują różne mechanizmy izolacji, takie jak cgroups, namespaces, SELinux, AppArmor, seccomp, Capabilities i inne.

5.Zasada najmniejszych uprawnień: Każda usługa powinna mieć tylko te uprawnienia, które są jej absolutnie niezbędne do działania.

6.Monitorowanie i logowanie: Śledź i analizuj aktywność w swoich kontenerach. Istnieje wiele narzędzi, które mogą pomóc w wykrywaniu niezwykłych lub podejrzanych aktywności.

7.Autentykacja i autoryzacja: Unikaj korzystania z domyślnych haseł. Zamiast tego, używaj silnych haseł lub kluczy SSH, a jeżeli to możliwe, wdrożenia uwierzytelniania dwuskładnikowego.

8.Zaszyfruj komunikację: Jeżeli kontener musi komunikować się z zewnętrznym światem, upewnij się, że ta komunikacja jest zaszyfrowana.

### Ekserymenty pokazujące niebizpicznoćś Dockera:
#### 1. Postawienie kontenera z luką w zabezpieczeniach:
Załóżmy, że mamy prosty kontener, który uruchamia usługę SSH i pozwala na logowanie za pomocą domyślnych lub słabych haseł. Dockerfile mógłby wyglądać tak:
```
FROM ubuntu:20.04

RUN apt-get update && apt-get install -y openssh-server
RUN echo 'root:password' | chpasswd

RUN mkdir /var/run/sshd
EXPOSE 22

CMD ["/usr/sbin/sshd", "-D"]
```
#### 2.1 Atak na niewłaściwe zarządzanie danymi poufnymi
Jednym z powszechnych błędów jest nieodpowiednie zarządzanie danymi poufnymi, takimi jak hasła, klucze prywatne, tokeny dostępu, itd.

Załóżmy, że masz taki Dockerfile:
``` 
FROM python:3.7

ENV SECRET_KEY="mysecretkey"
ADD . /app

WORKDIR /app
RUN pip install -r requirements.txt
CMD ["python", "app.py"]
```
Kontener utworzony z tego Dockerfile zawiera poufne dane ("mysecretkey") jako zmienną środowiskową.
#### 2.2. Atak
Jeśli atakujący zdobędzie dostęp do tego kontenera (na przykład poprzez lukę w aplikacji, którą ten kontener obsługuje), może odczytać tę zmienną środowiskową i wykorzystać tę informację do swoich celów. Atakujący mógłby użyć polecenia takiego jak:
```
echo $SECRET_KEY
```

## Uruchamianie kontenera Docker wewnątrz innego kontenera Docker
Uruchamianie kontenera Docker wewnątrz innego kontenera Docker, czyli Docker-in-Docker (DinD), może być przydatne w kilku scenariuszach. Oto kilka z nich:

Testowanie i rozwijanie aplikacji Docker: DinD może być przydatny, jeśli tworzysz aplikacje, które interaktywują z Dockerem lub zarządzają kontenerami Docker. Możesz uruchomić kontener DinD do tworzenia, uruchamiania i niszczenia innych kontenerów podczas testowania.

CI/CD (Continuous Integration / Continuous Deployment): Niektóre systemy CI/CD, takie jak GitLab CI, używają DinD, aby budować obrazy Docker podczas przepływu pracy CI. Każda praca CI jest uruchamiana w osobnym kontenerze, a jeśli praca musi budować obraz Docker, używa DinD.

Izolacja: Kontenery Docker zapewniają silną izolację pomiędzy aplikacjami. Uruchomienie Docker w Dockerze umożliwia dodatkową warstwę izolacji.

Pamiętaj jednak, że DinD ma swoje wady, w tym problemy z bezpieczeństwem (kontenery DinD muszą być uruchamiane z uprawnieniami roota), zarządzaniem zasobami i czystością danych. Zamiast DinD, lepszym rozwiązaniem może być Docker-outside-of-Docker (DooD), gdzie kontener Docker korzysta z daemon Docker z hosta, lub rozważenie użycia narzędzia do orkiestracji kontenerów, takiego jak Kubernetes.
jutro spotykamy się na żywo, żeby już wszystko zarem zebrać, prszeprowadzić wszystkie testy i td.

### Eksperyment 


#### Eksperyment 1: Docker-in-Docker (DinD)
1. Utwórz plik Dockerfile zawierający następujący kod:
```
FROM docker:dind
CMD ["dockerd", "--host=tcp://0.0.0.0:2376"]

```
2. Zbuduj obraz za pomocą polecenia docker build -t docker-in-docker .
3. Uruchom kontener używając polecenia docker run --privileged -p 2375:2376 -d docker-in-docker.
4. Wewnątrz tego kontenera, możesz teraz uruchamiać inne kontenery Docker za pomocą docker run. Na przykład: docker run hello-world.


#### Eksperyment 2: Docker-outside-of-Docker (DooD)

1.Utwórz plik Dockerfile zawierający następujący kod:
```
FROM docker
CMD ["docker", "run", "hello-world"]

```
2. Zbuduj obraz za pomocą polecenia docker build -t docker-outside-of-docker.
3. Uruchom kontener używając polecenia docker run -v /var/run/docker.sock:/var/run/docker.sock docker-outside-of-docker.
4. Teraz zobaczysz, że kontener docker-outside-of-docker jest w stanie uruchamiać inne kontenery Docker na tym samym hoście.

W obu przypadkach pamiętaj, że praca z Dockerem może wiązać się z pewnymi ryzykami bezpieczeństwa, zwłaszcza jeśli nadajesz kontenerom uprawnienia "privileged" lub udostępniasz im gniazdo Docker z hosta. Dlatego zawsze należy ostrożnie korzystać z tych funkcji i upewnić się, że są one odpowiednio zabezpieczone.

### Po co Uruchamiać kontener Docker w kontenerze Docker?

Uruchamianie kontenera Docker wewnątrz innego kontenera Docker, czyli Docker-in-Docker (DinD), może być przydatne w kilku scenariuszach. Oto kilka z nich:
1. Testowanie i rozwijanie aplikacji Docker: DinD może być przydatny, jeśli tworzysz aplikacje, które interaktywują z Dockerem lub zarządzają kontenerami Docker. Możesz uruchomić kontener DinD do tworzenia, uruchamiania i niszczenia innych kontenerów podczas testowania.
2. CI/CD (Continuous Integration / Continuous Deployment): Niektóre systemy CI/CD, takie jak GitLab CI, używają DinD, aby budować obrazy Docker podczas przepływu pracy CI. Każda praca CI jest uruchamiana w osobnym kontenerze, a jeśli praca musi budować obraz Docker, używa DinD.
3. Izolacja: Kontenery Docker zapewniają silną izolację pomiędzy aplikacjami. Uruchomienie Docker w Dockerze umożliwia dodatkową warstwę izolacji.

Pamiętaj jednak, że DinD ma swoje wady, w tym problemy z bezpieczeństwem (kontenery DinD muszą być uruchamiane z uprawnieniami roota), zarządzaniem zasobami i czystością danych. Zamiast DinD, lepszym rozwiązaniem może być Docker-outside-of-Docker (DooD), gdzie kontener Docker korzysta z daemon Docker z hosta, lub rozważenie użycia narzędzia do orkiestracji kontenerów, takiego jak Kubernetes.
