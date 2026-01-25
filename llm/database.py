from sqlalchemy import create_engine, MetaData
from sqlalchemy.ext.asyncio import create_async_engine, AsyncSession, async_sessionmaker
from sqlalchemy.orm import sessionmaker, declarative_base
from config import settings
import aiomysql
import asyncio
from typing import AsyncGenerator
import mysql.connector
from mysql.connector import pooling

# Synchronous SQLAlchemy setup (for migrations, sync operations)
DATABASE_URL = f"mysql+mysqlconnector://{settings.DB_USER}:{settings.DB_PASSWORD}@{settings.DB_HOST}:{settings.DB_PORT}/{settings.DB_NAME}"

engine = create_engine(
    DATABASE_URL,
    pool_size=settings.DB_POOL_SIZE,
    max_overflow=settings.DB_MAX_OVERFLOW,
    pool_recycle=settings.DB_POOL_RECYCLE,
    echo=settings.DEBUG
)

SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

# Async SQLAlchemy setup (recommended for FastAPI)
ASYNC_DATABASE_URL = f"mysql+aiomysql://{settings.DB_USER}:{settings.DB_PASSWORD}@{settings.DB_HOST}:{settings.DB_PORT}/{settings.DB_NAME}"

async_engine = create_async_engine(
    ASYNC_DATABASE_URL,
    pool_size=settings.DB_POOL_SIZE,
    max_overflow=settings.DB_MAX_OVERFLOW,
    pool_recycle=settings.DB_POOL_RECYCLE,
    echo=settings.DEBUG
)

AsyncSessionLocal = async_sessionmaker(
    async_engine,
    class_=AsyncSession,
    expire_on_commit=False
)

Base = declarative_base()
metadata = MetaData()

# Dependency for async database session
async def get_async_db() -> AsyncGenerator[AsyncSession, None]:
    async with AsyncSessionLocal() as session:
        try:
            yield session
        finally:
            await session.close()

# Dependency for sync database session
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

# Direct MySQL connection pool (without SQLAlchemy)
def create_mysql_pool():
    """Create MySQL connection pool for direct queries"""
    return pooling.MySQLConnectionPool(
        pool_name="mysql_pool",
        pool_size=10,
        pool_reset_session=True,
        host=settings.DB_HOST,
        port=settings.DB_PORT,
        database=settings.DB_NAME,
        user=settings.DB_USER,
        password=settings.DB_PASSWORD,
        charset='utf8mb4',
        autocommit=True
    )

mysql_pool = create_mysql_pool()

def get_mysql_connection():
    """Get connection from MySQL pool"""
    return mysql_pool.get_connection()