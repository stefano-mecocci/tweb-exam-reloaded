docker compose down --volumes --remove-orphans && \
docker rmi tweb-old-school-app:latest && \
docker compose up --build
