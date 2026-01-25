import json
from fastapi import FastAPI

from pydantic import BaseModel
from llama_cpp import Llama
from prompts import PROMPTS

llm = Llama(
    model_path="models/current-model.gguf",
    n_ctx=4096,
    n_threads=4,
    chat_format="llama-3",
    repeat_penalty=1.25,
    repeat_last_n=256,
)

app = FastAPI()

class Prompt(BaseModel):
    prompt: str
    chatId: int
    userId: int
    message: str


@app.post("/chat")
async def chat(prompt: Prompt):
    # Создаём историю для сессии, если нет
    if prompt.user_id not in chat_sessions:
        chat_sessions[prompt.user_id] = [
        ]

    session_history = chat_sessions[prompt.user_id]

    [
        {"role": "system", "content": prompt.prompt}

        // История
        {"role": "user", "content": prompt.message} # Вопрос от пользователя
        {"role": "assistant", "content": assistant_reply} # Ответ от ассистента

        // Новый запрос
        {"role": "user", "content": prompt.message} # Вопрос от пользователя
    ]

    # Добавляем новое сообщение пользователя
    session_history.append({"role": "user", "content": prompt.message})

    # Генерация ответа
    response = llm.create_chat_completion(
        messages=session_history,
        temperature=0.1,
        max_tokens=512,
        stop=["<|eot_id|>"],
    )

    assistant_reply = response["choices"][0]["message"]["content"].strip()

    # Добавляем ответ в историю
    session_history.append({"role": "assistant", "content": assistant_reply})

    # Обрезаем историю, если слишком длинная (например, последние 10 сообщений)
    if len(session_history) > 22:  # 1 system + 10 пар
        session_history = [session_history[0]] + session_history[-20:]
        chat_sessions[prompt.user_id] = session_history

    return {"reply": assistant_reply}


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)