<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        if (!$record) {
            return false;
        }
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        if (!$record) {
            return false;
        }
        return $record->delete();
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    public function where($column, $operator = null, $value = null)
    {
        return $this->model->where($column, $operator, $value);
    }

    public function updateWhere($id, $column, array $data)
    {
        $query = $this->model->newQuery();

        $query->where($column, $id)->update($data);

        return $query->find($id); // Return the updated record
    }

    public function paginate($perPage = 10)
    {
        return $this->model->paginate($perPage);
    }


    public function getWeeklyEnrolled($weekNumber, $model)
    {
        return $model::select(DB::raw('YEARWEEK(created_at, 1) as year_week'), DB::raw('WEEK(created_at, 1) as week'))
            ->whereRaw('YEARWEEK(created_at, 1) = YEARWEEK(NOW(), 1) - ?', [$weekNumber])
            ->orderBy('year_week', 'desc')
            ->count();
    }
    public function weeklyEnrollementData(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $labels = [];
        $data = [];

        $startDate = Carbon::now()->startOfWeek();

        $weekCounter = 4; // Start with Week 4
        $previousMonth = $startDate->copy()->subWeeks($start)->format('m'); // Get the month of the start date

        for ($i = $start; $i <= $end; $i++) {
            $date = $startDate->copy()->subWeeks($i);
            $currentMonth = $date->format('m');

            if ($currentMonth != $previousMonth) {
                $weekCounter = 4; // Reset week counter to 4 if the month changes
                $previousMonth = $currentMonth;
            }

            $labels[] = "Week " . ($weekCounter) . " (" . $date->format('d/m/Y') . ")";

            $data[] = $this->getWeeklyEnrolled($i, $this->model::class);

            $weekCounter--; // Decrement the week counter for each loop iteration

            if ($weekCounter < 1) {
                $weekCounter = 4; // Reset to Week 4 if it goes below 1
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }



    public function selectOptionDatalist(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);


        $query = $this->model::class::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $data = $query->paginate(10, ['*'], 'page', $page);




        $modifiedData = $data->map(function ($item) {
            $profileUrl = $item->profile_image ?? "";



            return [
                'id' => $item->id,
                'name' => $item->name ?? $item->proficience_name,
                'profile_url' => $profileUrl,

            ];
        });



        return response()->json([
            'results' => $modifiedData,
            'hasMore' => $data->hasMorePages()
        ]);
    }










}
