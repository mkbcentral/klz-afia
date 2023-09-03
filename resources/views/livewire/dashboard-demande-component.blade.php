<div class="p-4">
  <x-loading-indicator />
    <div class="d-flex justify-content-end">
        <div class="form-group w-25">
            <div class="input-group mb-3 mt-2 ml-">
                <select id="my-select" class="form-control" wire:model.defer="monthName">
                    <option value="">Mois en cours</option>
                    @foreach ($mois as $moi)
                        <option value="{{ $moi }}">{{ $moi }}</option>
                    @endforeach
                </select>
                <div class="input-group-prepend">
                    <button  wire:click='getByMonth' class="btn btn-primary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>

                </div>

            </div>
        </div>
    </div>
    <div>
        <div class="" style="width: 100%; height: 100%;">
            <div class=" style="width: 100%; height: 100%;"">
                <div class="">
                    <div id="chart1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$prives->count()}}</h3>

              <p>Privés</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a  class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$abonnes->count()}}<sup style="font-size: 20px"></sup></h3>

              <p>Abonnés</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$personnels->count()}}</h3>

              <p>Personnel</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$hosp_abn->count()+$hosp_pv->count()+$hosp_prsnl->count()}}</h3>

              <p>Hospitalisé</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
    </div>

    @push('js')
    <script>

        var options = {
        chart: {
            type: 'area',
            height: 350,
            zoom: {
                enabled: false
            },
            animations:{
                enabled:false
            }
        },

        legend: {
          horizontalAlign: 'left'
        },
        series: [{
            name: 'sales',
            data: @json($valeurs)
        }],
        xaxis: {
            categories: @json($categorie)
        }
        }

        var chart = new ApexCharts(document.querySelector("#chart1"), options);

        chart.render();
    </script>
@endpush

</div>
