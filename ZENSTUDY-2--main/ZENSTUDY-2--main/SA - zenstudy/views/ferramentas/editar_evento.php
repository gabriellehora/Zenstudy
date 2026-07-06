<input type="hidden" name="id" value="<?= $evento['id'] ?>">

<input
type="text"
name="titulo"
value="<?= $evento['titulo'] ?>">

<input
type="date"
name="dt_data"
value="<?= $evento['dt_data'] ?>">

<input
type="time"
name="horario"
value="<?= $evento['horario'] ?>">

<textarea
name="descricao"><?= $evento['descricao'] ?></textarea>

<input
type="color"
name="cor"
value="<?= $evento['cor'] ?>">

<button
type="submit"
name="editar">

Salvar Alterações

</button>