from pydantic_settings import BaseSettings
from typing import Optional

class Settings(BaseSettings):
    # Database settings
    DB_HOST: str = "mysql"
    DB_PORT: int = 3306
    DB_NAME: str = ""
    DB_USER: str = ""
    DB_PASSWORD: str = ""
    DB_POOL_SIZE: int = 10
    DB_MAX_OVERFLOW: int = 20
    DB_POOL_RECYCLE: int = 3600
    
    # Application settings
    APP_NAME: str = "LLM Service"
    DEBUG: bool = False

    class Config:
        env_file = ".env"

settings = Settings()