import psycopg2

def get_connection():
    return psycopg2.connect(
        dbname="tp",
        user="postgres",
        password="postgres",
        host="localhost",
        port="5432"
    )

def add_student(conn, name, grade):
    with conn.cursor() as cur:
        cur.execute("INSERT INTO students (name, grade) VALUES (%s, %s)", (name, grade))
    conn.commit()

def get_student(conn, name):
    with conn.cursor() as cur:
        cur.execute("SELECT name, grade FROM students WHERE name = %s", (name,))
        row = cur.fetchone()
        return row if row else None

# C'EST CETTE FONCTION QUE VOUS DEVEZ ÉCRIRE POUR L'EXERCICE 2
def average_grade(conn):
    with conn.cursor() as cur:
        cur.execute("SELECT AVG(grade) FROM students;")
        result = cur.fetchone()[0]
    conn.commit()
    return float(result) if result is not None else None