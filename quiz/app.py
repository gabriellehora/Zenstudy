from flask import Flask, render_template, request, redirect, url_for, jsonify, session, flash
app = Flask(__name__)
app.secret_key = 'segredo' # necessario para usar o session
import mysql.connector
from werkzeug.security import generate_password_hash, check_password_hash
import requests
from datetime import datetime


#========Conexão com banco=========
def conectar():
    return mysql.connector.connect(
        host="tini.click",
        port="3306",
        user="zenstudy",
        password="5564b6c2da8a08044d696ea0a4e82e29", # coloque sua senha do mysql
        database="zenstudy"
    )

#======== Login =========
@app.route('/login')
def login():
    if session.get('logado'):
        return redirect(url_for('menu'))
    return render_template('login.html')

@app.route('/login', methods=['POST'])
def login_post():
    email = request.form.get('email')
    senha = request.form.get('senha')

    conexao = conectar()
    cursor = conexao.cursor(dictionary=True, buffered=True)
    cursor.execute("SELECT * FROM tb_cadastro WHERE ds_email=%s AND ds_senha=%s", (email, senha))
    user = cursor.fetchone()
    cursor.close()
    conexao.close()

    if user:
        session['logado'] = True
        session['email'] = user['ds_email']
        session['id_cadastro'] = user['id']
        return redirect(url_for('menu'))
    else:
        flash("Usuário ou senha incorretos.","erro")
        return redirect(url_for('login'))
    

# ========= CADASTRAR USUÁRIO ==========
@app.route('/cadastro', methods=['GET', 'POST'])
def cadastro():
    if request.method == 'POST':
        nome = request.form.get('nome')
        email = request.form.get('email')
        senha = request.form.get('senha')

        if nome and email and senha:
            conexao = conectar()
            cursor = conexao.cursor(dictionary=True, buffered=True)
            sql = "INSERT INTO tb_cadastro (nm_usuario, ds_email, ds_senha) VALUES (%s, %s, %s)"
            valores = (nome, email, senha)
            cursor.execute(sql, valores)
            conexao.commit()
            cursor.close()
            conexao.close()
            session['usuario_logado'] = email 
            session['nome_usuario'] = nome
            flash('Cadastro realizado com sucesso! Bem-vindo.', 'sucesso')
            return redirect(url_for('menu'))
        
    return render_template('cadastro.html')
#======== Agenda ===========
@app.route('/agenda')
def agenda():
    if not session.get('logado'):
        return redirect('/login')
    return render_template('agenda.html')

#  calendário
@app.route('/calendario')
def calendario():
    if not session.get('logado'):
        return redirect('/login')
    return render_template('calendario.html')


# Adicionar Evento
@app.route('/adicionar_eventos', methods=['GET', 'POST'])
def adicionar_eventos():

    if request.method == 'POST':
        titulo = request.form.get('titulo')
        descricao = request.form.get('descricao')
        horario = request.form.get('horario')
        dt_data = request.form.get('dt_data')

        if titulo and descricao and horario and dt_data:
            conexao = conectar()
            cursor = conexao.cursor(dictionary=True, buffered=True)
            sql = "INSERT INTO tb_agenda (titulo, descricao, horario, dt_data) VALUES (%s, %s, %s, %s)"
            valores = (titulo, descricao, horario, dt_data)
            cursor.execute(sql, valores)
            conexao.commit()
            cursor.close()
            conexao.close()
            flash("Evento salvo com sucesso!", "sucesso")
            return redirect(url_for('calendario'))
        
    flash("Preencha todos os campos!", "erro")
    return redirect(url_for('calendario'))

# Enviar eventos para o calendário
@app.route('/eventos')
def eventos():

    con = conectar()
    cursor = con.cursor(dictionary=True)
    cursor.execute(""" SELECT id, titulo AS title, CONCAT(dt_data, 'T', horario) AS start, descricao FROM tb_agenda """)
    eventos = cursor.fetchall()
    cursor.close()
    con.close()

    return jsonify(eventos)

#======= Fim da Agenda =============

#======= Pesquisa ==========

#Funções de Integração com Wikipedia 
def buscar_wikipedia(termo):
    """
    Busca artigos na API da Wikipedia em Português.
    Retorna uma lista de dicionários com 'titulo', 'descricao' (snippet), e 'materia'.
    """
    S = requests.Session()
    # Endpoint da API para a Wikipedia em Português
    URL = "https://pt.wikipedia.org/w/api.php"

    # Parâmetros para buscar e obter um trecho (snippet) dos resultados
    params_search = {
        "action": "query",
        "format": "json",
        "list": "search",
        "srsearch": termo,
        "srlimit": 5, # Limita a 5 resultados
        "srprop": "snippet|titlesnippet" 
    }

    # ATENÇÃO: É fundamental usar um User-Agent para identificar sua aplicação.
    # Por favor, substitua a string abaixo por uma que te identifique.
    headers = {
        'User-Agent': 'ZenStudy-App (Projeto-Estudos-Usuario; contato@exemplo.com)' 
}
    try:
        R = S.get(url=URL, params=params_search, headers=headers)
        R.raise_for_status() # Lança exceção para erros HTTP
        DATA = R.json()

        resultados_wiki = []
        if 'query' in DATA and 'search' in DATA['query']:
            for item in DATA['query']['search']:
                
                snippet_limpo = item['snippet'].replace('<span class="searchmatch">', '').replace('</span>', '')
                
                resultados_wiki.append({
                    'titulo': item['title'],
                    'descricao': snippet_limpo + " [Fonte: Wikipedia]",
                    'materia': termo 
})
        
        return resultados_wiki

    except requests.exceptions.RequestException as e:
        print(f"ERRO API WIKIPEDIA: Falha ao acessar a API da Wikipedia: {e}")
        return []
    
@app.route('/pesquisa', methods=['GET', 'POST'])
def pesquisa():
    resultado_local = None
    resultado_wikipedia = None
    mensagem = None
    termo = None

    if request.method == 'POST':
        termo = request.form['termo']

        conn = conectar()
        cursor = conn.cursor(dictionary=True)

        # 1. Pesquisa na base de dados local
        # Busca no título, descrição ou matéria.
        sql = "SELECT * FROM tb_biblioteca WHERE titulo LIKE %s OR descricao LIKE %s OR materia LIKE %s"
        cursor.execute(sql, (f"%{termo}%", f"%{termo}%", f"%{termo}%"))
        resultado_local = cursor.fetchall()
        
        cursor.close()
        conn.close() # Fecha a conexão MySQL

        # 2. Se não houver resultados locais, pesquisa na Wikipedia
        if not resultado_local:
            resultado_wikipedia = buscar_wikipedia(termo)
            if resultado_wikipedia:
                mensagem = "Nenhum resultado local encontrado. Resultados externos (Wikipedia) encontrados."
            else:
                mensagem = "Nenhum resultado encontrado, nem na base de dados local, nem na Wikipedia."
        else:
            mensagem = f"{len(resultado_local)} resultados locais encontrados."


    # Passa ambos os resultados e o termo de pesquisa para o template
    return render_template('pesquisa.html', 
                           resultado_local=resultado_local, 
                           resultado_wikipedia=resultado_wikipedia, 
                           mensagem=mensagem,
                           termo_pesquisa=termo)

#======= Fim da pesquisa =============

#========= Biblioteca =========
@app.route('/biblioteca')
def biblioteca():
    if not session.get('logado'):
        return redirect(url_for('login'))
    return render_template('biblioteca.html')

#  FUNDAMENTAL
@app.route("/materiais/fundamental/<int:ano_id>")
def materiais_fundamental(ano_id):
    conexao = conectar()
    cursor = conexao.cursor(dictionary=True)

    cursor.execute("SELECT nome FROM tb_anos WHERE id = %s", (ano_id,))
    ano = cursor.fetchone()

    if not ano:
        cursor.close()
        conexao.close()
        return "Ano não encontrado no banco", 404

    cursor.execute("SELECT * FROM tb_materias WHERE nivel_id = 1")
    materias = cursor.fetchall()

    cursor.close()
    conexao.close()

    return render_template(
        "materiais.html",
        nivel="Ensino Fundamental",
        ano=ano["nome"],
        ano_id=ano_id,
        materias=materias
    )


# ENSINO MÉDIO 
@app.route("/materiais/medio/<int:ano_id>")
def materiais_medio(ano_id):
    conexao = conectar()
    cursor = conexao.cursor(dictionary=True)

    cursor.execute("SELECT nome FROM tb_anos WHERE id = %s", (ano_id,))
    ano = cursor.fetchone()

    if not ano:
        cursor.close()
        conexao.close()
        return "Ano não encontrado no banco", 404

    cursor.execute("SELECT * FROM tb_materias WHERE nivel_id = 2")
    materias = cursor.fetchall()

    cursor.close()
    conexao.close()

    return render_template(
        "materiais.html",
        nivel="Ensino Médio",
        ano=ano["nome"],
        ano_id=ano_id,
        materias=materias
    )

# ENEM
@app.route("/materiais/enem/<int:ano_id>")
def materiais_enem(ano_id):
    conexao = conectar()
    cursor = conexao.cursor(dictionary=True)

    # Pega a área do ENEM
    cursor.execute("SELECT nome FROM tb_anos WHERE id = %s AND nivel_id = 3", (ano_id,))
    area = cursor.fetchone()
    if not area:
        cursor.close()
        conexao.close()
        return "Área do ENEM não encontrada", 404

    # Pega os assuntos da área
    cursor.execute("""
        SELECT id, titulo, descricao
        FROM tb_assuntos
        WHERE ano_id = %s
    """, (ano_id,))
    assuntos = cursor.fetchall()

    cursor.close()
    conexao.close()

    # Renderiza diretamente o template de estudos, pulando os botões
    return render_template(
        "estudos.html",
        materia_title=f"ENEM - {area['nome']}",
        ano_nome=area['nome'],
        assuntos=assuntos,
        mostrar_descricao=True  # <--- importante para mostrar tudo direto
    )


#  ESTUDOS / ASSUNTOS 
@app.route("/estudos/<int:ano_id>/<int:materia_id>")
def estudos_area(ano_id, materia_id):
    conexao = conectar()
    cursor = conexao.cursor(dictionary=True)

    cursor.execute("SELECT nome FROM tb_materias WHERE id = %s", (materia_id,))
    materia = cursor.fetchone()

    cursor.execute("SELECT nome FROM tb_anos WHERE id = %s", (ano_id,))
    ano = cursor.fetchone()

    if not materia or not ano:
        cursor.close()
        conexao.close()
        return "Matéria ou ano não encontrado", 404

    cursor.execute("""
        SELECT id, titulo, descricao 
        FROM tb_assuntos 
        WHERE materia_id = %s AND ano_id = %s
    """, (materia_id, ano_id))

    assuntos = cursor.fetchall()

    cursor.close()
    conexao.close()

    return render_template(
        "estudos.html",
        materia_title=materia["nome"],
        ano_nome=ano["nome"],
        assuntos=assuntos
    )

@app.route("/conteudo/<int:assunto_id>")
def conteudo(assunto_id):
    conexao = conectar()
    cursor = conexao.cursor(dictionary=True)

    cursor.execute("SELECT * FROM tb_assuntos WHERE id = %s", (assunto_id,))
    assunto = cursor.fetchone()

    if not assunto:
        return "Conteúdo não encontrado"

    return render_template("conteudo.html", assunto=assunto)

#======= Fim da biblioteca =============

#======= CONFIGURAÇÕES =======
@app.route('/configuracoes')
def configuracoes():
    if not session.get('logado'):
        return redirect('/login')
    return render_template('configuracoes.html')

# alterar senha
@app.route('/alterar_senha', methods=['GET', 'POST'])
def alterar_senha():
    if not session.get('logado'):
        return redirect('/login')

    id = session.get('id_cadastro') 
    
    if request.method == 'POST':
        senha_atual = request.form['senha_atual']
        nova_senha = request.form['nova_senha']
        confirmar_senha = request.form['confirmar_senha']

        if nova_senha != confirmar_senha:
            flash("As novas senhas não coincidem!", "erro")
            return redirect(url_for('alterar_senha'))

        conexao = conectar()
        cursor = conexao.cursor(dictionary=True) 
        
        try:
            cursor.execute("SELECT ds_senha FROM tb_cadastro WHERE id = %s", (id,))
            user = cursor.fetchone()
            
            if not user or senha_atual != user['ds_senha']:
                flash("Senha atual incorreta!", "erro")
                return redirect(url_for('alterar_senha'))

            cursor.execute("UPDATE tb_cadastro SET ds_senha = %s WHERE id = %s", (nova_senha, id))
            conexao.commit()
            
            flash("Senha alterada com sucesso!", "sucesso")
            return redirect(url_for('configuracoes'))

        except Exception as e:
            flash("Erro ao processar a solicitação.", "erro")
            print(f"Database error in /alterar_senha: {e}")
        finally:
            cursor.close()
            conexao.close()

    return render_template('alterar_senha.html')

# editar perfil
@app.route('/editar_perfil', methods=['GET', 'POST'])
def editar_perfil():
    if not session.get('logado'):
        return redirect('/login')

    id = session.get('id_cadastro') 
    conexao = conectar()
    cursor = conexao.cursor(dictionary=True)

    if request.method == 'POST':
        nome = request.form['nome']
        email = request.form['email']
        
        try:
            sql = "UPDATE tb_cadastro SET nm_usuario = %s, ds_email = %s WHERE id = %s"
            valores = (nome, email, id)
            cursor.execute(sql, valores)
            conexao.commit()

            session['email'] = email 
            
            flash("Perfil atualizado com sucesso!", "sucesso")
        except Exception as e:
            flash("Erro ao atualizar o perfil.", "erro")
            print(f"Database error in /editar_perfil POST: {e}")
        finally:
            cursor.close()
            conexao.close()
            return redirect(url_for('editar_perfil'))

    try:
        cursor.execute("SELECT nm_usuario, ds_email FROM tb_cadastro WHERE id = %s", (id,))
        dados = cursor.fetchone()
    except Exception as e:
        flash("Erro ao carregar dados do perfil.", "erro")
        print(f"Database error in /editar_perfil GET: {e}")
        dados = None
    finally:
        cursor.close()
        conexao.close()

    if dados:
        return render_template('editar_perfil.html', nome=dados['nm_usuario'], email=dados['ds_email'])
    
    flash("Não foi possível carregar os dados do perfil.", "erro")
    return redirect(url_for('configuracoes'))

# tema
@app.route('/tema', methods=['GET', 'POST'])
def tema():
    if not session.get('logado'):
        return redirect('/login')

    if request.method == 'POST':
        session['tema'] = request.form['modo']
        flash("Tema alterado com sucesso!", "info")
        return redirect(url_for('tema'))

    tema_atual = session.get('tema', 'claro')
    return render_template('tema.html', tema=tema_atual)

@app.route("/alterar-tema", methods=["POST"])
def alterar_tema():
    session["tema"] = request.form.get("tema")
    return redirect(url_for("configuracoes"))


# sobre o app
@app.route('/sobre')
def sobre():
    if not session.get('logado'):
        return redirect('/login')
    return render_template('sobre.html')

#=============== Fim Configurações =================

#Rota do index
@app.route('/')
def index():
    return render_template('index.html')

""""""
#Rota do menu
@app.route('/menu')
def menu():
    if not session.get('logado'):
        return redirect(url_for('login'))
    return render_template('menu.html')

@app.route('/logout')
def logout():
    session.clear()
    flash('Você saiu do sistema.', 'info')
    return redirect(url_for('login'))

if __name__ == '__main__':
    app.run(debug=True)
