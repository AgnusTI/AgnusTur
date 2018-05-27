<tr>

    <th colspan="4">Quantidade de passeios: {{ number_format($qtd, 0, ',', '.') }}</th>

    <th class="text-right">{{ $adults }}</th>
    <th class="text-right">{{ $childs }}</th>
    <th class="text-right">{{ $childs + $adults }}</th>
    <th colspan="9"></th>

</tr>

<tr>

    <td colspan="16">

        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
            <form class="col-md-12">
                <input type="hidden" value="{{ $e->item_id }}" name="item_id"/>
                <input type="hidden" value="{{ $e->dt_tour }}" name="dt_tour"/>

                <div class="form-group col-md-5">
                    <div class="input-group col-md-12">
                        <label>Motorista</label>
                        <input type="text" value="{{ $e->driver_name }}"  class="form-control" name="driver_name"/>
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="input-group col-md-12">
                        <label>Guia</label>
                        <input type="text" value="{{ $e->guide_name }}"  class="form-control" name="guide_name"/>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label> </label>
                    <div class="input-group">
                        <a href="#" class="btn btn-primary" name="btnSaveLogistics"><i class="fa fa-save"></i> Salvar</a>
                    </div>
                </div>
            </form>

        @else
            <div class="col-md-12">
                <div class="form-group col-md-5">
                    <div class="input-group col-md-12">
                        <label>Motorista</label>
                        <input type="text" value="{{ $e->driver_name }}"  class="form-control" name="driver_name" disabled="disabled"/>
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="input-group col-md-12">
                        <label>Guia</label>
                        <input type="text" value="{{ $e->guide_name }}"  class="form-control" name="guide_name" disabled="disabled"/>
                    </div>
                </div>

            </div>
        @endif



    </td>

</tr>