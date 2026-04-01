
                <table id="historyPatrimony" class="table table-hover table-bordered table-sm border-<?=CONF_APP_COLOR?> p-2" style="width:100%">
                    <thead class="table-<?=CONF_APP_COLOR?>">
                        <tr>
                            <th class="text-center"><i class="bi bi-pencil"></i></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">CRIADO</th>
                            <th class="text-center">ESTADO</th>
                            <th class="text-center">PRODUTO</th>
                            <th class="text-center">TPN</th>
                            <th class="text-center">PARTNUMBER</th>
                            <th class="text-center">LOGIN</th>
                            <th class="text-center">RF</th>
                            <th class="text-center">NOME</th>
                            <th class="text-center">CEL</th>
                            <th class="text-center">EMAIL</th>
                            <th class="text-center">TERMO</th>
                            <th class="text-center">TERMO ASS</th>
                            <th class="text-center">UNIDADE</th>
                            <th class="text-center">OBSERVACOES</th>
                            <?php if ($user->level_id > 3){?>
                                <th class="text-center">EXCLUIR</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($historico)){ ?>
                    <?php foreach ($historico as $lista): ?>
                        <tr>
                            <td class="text-center"><a role="button" href="<?=url("beta/patrimonio/historico/editar/{$lista->id}")?>" accesskey="a" class="btn btn-warning rounded-circle btn-sm fw-semibold text-"><i class="bi bi-pencil text-secondary"></i></a></td>
                            <td class="text-center fw-semibold"><?=$lista->id?></td>
                            <td class="text-center fw-semibold"><?=date_fmt_null($lista->created_history)?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->movement()->movement_name) ? $lista->movement()->movement_name : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->product()->product_name) ? $lista->product()->id.' - '.$lista->product()->product_name : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->product()->type_part_number) ? $lista->product()->type_part_number : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->part_number) ? $lista->part_number : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->user()->login) ? $lista->user()->login : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->user()->rf) ? $lista->user()->rf : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->user()->user_name) ? $lista->user()->user_name : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->user()->cell_phone) ? '('.substr($lista->user()->cell_phone, 0, 2).')'.substr($lista->user()->cell_phone, 2, 9) : "")?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->user()->email) ? $lista->user()->email : "")?></td>
                            <td class="text-center fw-semibold"><?=$lista->termList();?></td>
                            <td class="text-center"><?=$lista->fileList()?></td>
                            <td class="text-center fw-semibold"><?=(!empty($lista->unit()->unit_name) ? $lista->unit()->unit_name : "")?></td>
                            <td class="text-center fw-semibold"><?=$lista->observations?></td>
                            <?php if ($user->level_id > 3){?>
                            <td class="text-center"><button type="button" data-bs-togglee="modal" accesskey="b" data-bs-toggle="modal" data-bs-target="#trash-<?=$lista->id;?>" 
                                class="btn btn-outline-danger rounded-circle btn-sm text-center"><i class="bi bi-trash"></i></b></td>
                                    <!-- Modal -->
                                <div class="modal fade" id="trash-<?=$lista->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-light">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-trash me-2"></i> EXCLUIR <?=$lista->id;?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body fs-5 text-center">
                                                Deseja excluir o histórico id: <?=$lista->id?> ?
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger fw-semibold me-3" data-bs-dismiss="modal">NÃO</button>
                                                <a href="../historico/excluir/<?=$lista->id?>/delete" role="button" accesskey="s" class="btn btn-sm btn-outline-success fw-semibold"><u>S</u>IM</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </tr>
                        <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>


