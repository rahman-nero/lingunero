#!/bin/bash

MODEL_URL=${1:-"false"}

if [ "$MODEL_URL" != "false" ] && [ -n "$MODEL_URL" ]; then
    echo "Downloading LLM model from: $MODEL_URL"
    wget --progress=bar:force -O current-model.gguf "$MODEL_URL"

    # Проверка успешности загрузки
    if [ $? -eq 0 ]; then
        echo "Model downloaded successfully"
    else
        echo "Failed to download model" >&2
        exit 1
    fi
else
    echo "Skipping model download (URL not provided or set to false)"
fi