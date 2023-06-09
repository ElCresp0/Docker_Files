# Docker_Files
Project for purposes of Advanced Computer Architectures course. It contains an overview of functionalities provided by Docker.

# Raport

## Wstęp teoretyczny

### Docker image, docker container - rozróżnienie

Obraz (docker image) można traktować jako statyczny szablon, za pomocą którego tworzy się kontenery. Kontener stanowi działające środowisko do uruchamiania aplikacji.
- Można utworzyć kilka kontenerów z jednego obrazu
- Można tworzyć nowe obrazy z obrazów bazowych (koncepcja warstw)
- Kontener jest:
    - izolowany - od systemu hosta i pozostałych procesów (system plików, sieć, zasoby systemowe, przestrzenie nazw)
    Kontenery mogą jednak współdzielić kernel (dzięki czemu są lżejsze ale mniej izolowane)
    - przenośny - zdatny do uruchomienia na dowolnym urządzeniu obsługującym dockera, z gwarancją identycznego wewnętrznego środowiska w każdej fazie cyklu życia oprogramowania
    - wirtualny - stanowi wirtualny system operacyjny

### Docker container, maszyna wirtualna - rozróżnienie

Kontenery, podobnie jak maszyny wirtualne zapewniają wirtualny system operacyjny, w którym można uruchamiać aplikacje. Główną zaletą kontenerów jest ich lekkość wynikająca z możliwości współdzielenia kernela systemu operacyjnego.
- Wirtualizacja maszyn wirtualnych ma miejsce na poziomie hardware, co wymaga większej ilości zasobów w stosunku do kontenerów
- Wirtualizacja kontenerów zachodzi na poziomie aplikacji, dzięki czemu są znacznie lżejsze (współdzielenie zasobów, izolacja procesów)
- Kontenery dzięki wymienionym cechom są wydajnym narzędziem w kontekście cyklu wytwarzania aplikacji (wytwarzanie, testowanie, wdrażanie), ponieważ zapewniają identyczne środowisko uruchomieniowe na każdym z tych etapów
    - Dzięki temu stały się popularnym narzędziem w procesach CI/CD

## Wyciąg z dokumentacji - opis wybranych elementów

### Dockerfile

Plik Dockerfile stanowi opis obrazu Dockera, który można utworzyć komendą:
```
$ docker build (utworzenie obrazu)
```
lub
```
$ docker run (utworzenie obrazu i uruchomienie kontenera)
```
Elementy Dockerfile wykorzystane w prezentowanym przykładzie:
- FROM [obraz bazowy]
    - Definiuje wykorzystywany obraz bazowy
- RUN [komenda shellowa]
    - tworzy nową warstwę obrazu dockera, która powstaje po wykonaniu komendy; warstwy są cache'owane, co przyspiesza proces tworzenia nowych obrazów
- COPY [plik_kopiowany plik_docelowy]
    - kopiuje pliki z systemu hosta do obrazu
- CMD [komenda]
    - opisuje komendę lub punkt wejściowy (może zastępować element ENTRYPOINT lub mu towarzyszyć) kontenera, definiuje jego zachowanie przy uruchomieniu

### docker-compose.yml

Plik opisujący wiele obrazów dockera (serwisy), które tworzą logicznie jedną aplikację. W prezentowanym przykładzie są to serwisy php, apache oraz bazy danych potrzebne do uruchomienia aplikacji projektowej z przedmiotu Wytwarzanie Aplikacji Internetowych.
Plik ten wykorzystywany jest jako wejście narzędzia docker compose, które uruchamia się komendami podobnymi do standardowego tworzenia kontenerów:
```
$ docker compose build (tworzy obrazy Dockera)
```
```
$ docker compose up (tworzy i uruchamia kontenery)
```
```
$ docker compose start (uruchamia wcześniej utworzone kontenery)
```
```
$ docker compose stop (zatrzymuje kontenery)
```
```
$ docker compose down (usuwa kontenery i obrazy)
```
Wykorzystane elementy pliku .yml:
- services
    - zawiera listę serwisów (opisów obrazów Dockera) współtworzących aplikację
- build
    - opcjonalny, przekazuje ścieżkę do pliku Dockerfile
- image
    - specyfikuje obraz bazowy
- links
    - wskazuje na powiązania pomiędzy docelowymi kontenerami (np. php z bazą danych)
- environment
    - ustawia zmienne środowiskowe w obrazie (np. login i hasło do serwisu bazy danych)
- ports
    - opsiuje porty komunikacji przypisane docelowemu kontenerowi
- volumes
    - mapuje foldery między systemem hosta i kontenerem
- working_dir
    - definiuje miejsce w systemie plików, w którym uruchomiony zostanie kontener

## Przykład Dockerfile

W ramach prostego przykładu Dockerfile przygotowano skonteneryzowaną wersję projektu z przedmiotu Metody Numeryczne wykorzystującego język Python z dołączonym Matlabem. W tym celu utworzono obraz z obrazu bazowego dostarczonego przez Matlab, oraz zainstalowano na nim Pythona w wybranej wersji. Wykorzystanie dockera rozwiązuje w tym przypadku komplikacje wynikające z instalowania i wykorzystywania kilku wersji Pythona na systemie hosta.
Dalszy opis przykładu, jak również instrukcje jego uruchomienia można znaleźć w pliku README w katalogu python2_MN/

Uwaga: aby poprawnie uruchomić program test.py w kontenerze, należy uprzednio wygenerować licencję na stronie Matlaba dedykowaną na ten kontener (przy generowaniu podaje się MAC).

## Przykład docker compose

Z wykorzystaniem narzędzia docker compose znacznie przyspieszono proces przygotowywania środowiska uruchomieniowego pod projekt z przedmiotu Wytwarzanie Aplikacji Internetowych. Dla nadmiarowości oprócz mongodb dodano również serwisy z MySQL oraz phpmyadmin, które również są popularnymi narzędziami w aplikacjach internetowych. Podobnie jak w przypadku przykładu Dockerfile, dalszy opis oraz instrukcje uruchomienia zawarte są w dedykowanym pliku README w katalogu php_apache_db/

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
