<div>
    <x-loading-indicator  />
    <div class="p-2">
        <div class="d-flex justify-content-between">
            <div class="mt-2">
                <span style="font-size: 20px">SITUATION FACTURATION</span>
            </div>
            <div class="form-group w-25">
                <div class="input-group mb-3 mt-2 ml-">
                    <select id="my-select" class="form-control" wire:model.defer="monthName">
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
        <div class="row" >
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text text-bold" style="font-size: 25px">OCC</span>
                  <span class="info-box-number" style="font-size: 30px">
                    {{number_format($factureOcc,1)}}
                    <small>USD</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text text-bold" style="font-size: 25px">CNSS</span>
                    <span class="info-box-number" style="font-size: 30px">
                      {{number_format($factureCnss,1)}}
                      <small>USD</small>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-nurse"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text text-bold" style="font-size: 25px">Hosp. privés</span>
                    <span class="info-box-number" style="font-size: 30px">
                      {{number_format($facturePriveHosp,1)}}
                      <small>USD</small>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-minus"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text text-bold" style="font-size: 25px">Ambulant privés</span>
                    <span class="info-box-number" style="font-size: 30px">
                      {{number_format($factureAmbulantPv,1)}}
                      <small>USD</small>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>

        <div>
            <div class="" style="width: 100%; height: 100%;">
                <div class=""" style="width: 100%; height: 100%;">
                    <div class="">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            data: @json($montant)
        }],
        xaxis: {
            categories: @json($societes)
        }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();

        document.addEventListener('livewire:load',()=>{
            @this.on('refreshChart',(chartData)=>{
                //console.log('Ok !');
                 chart.updateSeries([{
                     data:chartData.seriesData
                 }])
            })
        })
    </script>
@endpush
