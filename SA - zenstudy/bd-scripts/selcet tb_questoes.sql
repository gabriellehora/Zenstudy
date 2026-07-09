SELECT *
FROM tb_questoes
WHERE materia = 'História'
AND nivel = 'Ensino Médio'
AND assunto = 'Revolução Francesa'
ORDER BY RAND()
LIMIT 10;