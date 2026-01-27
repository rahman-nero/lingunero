FROM python:3.12

ARG LLM_URL

ENV LLM_URL=$LLM_URL \
    PYTHONUNBUFFERED=1 \
    PYTHONDONTWRITEBYTECODE=1

WORKDIR /var/www

# Копируем сначала requirements для лучшего кеширования
COPY ./llm/requirements.txt .
RUN pip install --no-cache-dir --upgrade -r requirements.txt

# Копируем остальные файлы
COPY ./llm .

# Создаем директорию для моделей и скачиваем
RUN mkdir -p /var/www/models && \
    cd /var/www/models && \
    chmod +x ./download.sh && \
    bash ./download.sh $LLM_URL

EXPOSE 80

CMD ["fastapi", "run", "app.py", "--port", "80", "--proxy-headers"]

