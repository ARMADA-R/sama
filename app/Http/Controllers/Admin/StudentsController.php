<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StudentsDataTable;
use App\Http\Controllers\Controller;
use App\Models\cities;
use App\Models\Division;
use App\Models\Language;
use App\Models\Level;
use App\Models\Nationality;
use App\Models\Parents;
use App\Models\Religion;
use App\Models\Role;
use App\Models\Student;
use App\Models\StudentHealthRecords;
use App\Models\StudentLanguage;
use App\Models\StudentLevels;
use App\Models\StudentNationality;
use App\Models\StudentTransportation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentsController extends Controller
{
    //
    public function students(StudentsDataTable $student)
    {
        // $this->authorize('viewAny', User::class);
        return ($student->render('admin.students.students-index'));
    }

    public function showCreateStudentView()
    {
        $roles = Role::all();
        $nationalities = Nationality::all();
        $religions = Religion::all();
        $levels = Level::all();
        $languages = Language::all();
        $cities = Cities::orderBy('title')->get();

        return view('admin.students.students-create', ['cities' => $cities, 'languages' => $languages, 'nationalities' => $nationalities, 'religions' => $religions, 'levels' => $levels,]);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $data = ($request->all());
        Validator::make($data, [
            'firstName' => ['required', 'max:190'],
            'lastName' => ['required', 'max:190'],
            'gender' => ['required', 'max:190', Rule::in(['male', 'female'])],
            'nationality' => ['required', 'max:190', 'exists:App\Models\Nationality,id'],
            'birth_place' => ['required', 'max:190'],
            'birth_date' => ['required', 'max:190'],
            'religion' => ['required', 'max:190', 'exists:App\Models\Religion,id'],
            'level_to_study' => ['required', 'max:190', 'exists:App\Models\Level,id'],
            'phone' => ['required', 'max:190'],
            'telephone' => ['required', 'max:190'],
            'addMotherType' => ['required', 'max:190'],
            'addFatherType' => ['required', 'max:190'],
            'transportation' => ['required', 'max:190'],
            'city' => ['required', 'max:190', 'exists:App\Models\Cities,id'],
            'area' => ['required', 'max:190'],
            'street' => ['required', 'max:2550'],
            'emergency_phone' => ['required', 'max:190'],
            'kinship' => ['required', 'max:190'],
        ], [], [])->validate();

        if (isset($data['school_sequence'])) {
            foreach ($data['school_sequence'] as $value) {
                Validator::make($value, [
                    'school_name' => ['required', 'max:190'],
                    'status' => ['required', 'max:190', Rule::in([0, 1])],
                    'level' => ['required', 'max:190', 'exists:App\Models\Level,id'],
                ], [], [])->validate();
            }
        }

        if ($data['addMotherType'] == 1) {
            Validator::make($data, [
                'mother_firstName' => ['required', 'max:190'],
                'mother_lastName' => ['required', 'max:190'],
                'mother_job' => ['required', 'max:190'],
                'mother_phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone', function ($attribute, $value, $fail) use ($data) {
                    if (isset($data['father_phone'])) {
                        if ($value == $data['father_phone']) {
                            $fail('The ' . $attribute . ' must be unique.');
                        }
                    }
                },],
            ], [], [])->validate();
        } else {
            Validator::make($data, [
                'exest_mother_id' => ['required', 'max:190', 'exists:App\Models\Parents,id'],
            ], [], [])->validate();
        }

        if ($data['addFatherType'] == 1) {
            Validator::make($data, [
                'father_firstName' => ['required', 'max:190'],
                'father_lastName' => ['required', 'max:190'],
                'father_job' => ['required', 'max:190'],
                'father_phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone', function ($attribute, $value, $fail) use ($data) {
                    if (isset($data['mother_phone'])) {
                        if ($value == $data['mother_phone']) {
                            $fail('The ' . $attribute . ' must be unique.');
                        }
                    }
                }],
            ], [], [])->validate();
        } else {
            Validator::make($data, [
                'exest_father_id' => ['required', 'max:190', 'exists:App\Models\Parents,id'],
            ], [], [])->validate();
        }

        if (isset($data['health-problems'])) {
            foreach ($data['health-problems'] as $value) {
                Validator::make($value, [
                    'health_problem' => ['required', 'max:190'],
                ], [], [])->validate();
            }
        }
        if (isset($data['languages'])) {
            foreach ($data['languages'] as $value) {
                Validator::make($value, [
                    'level' => ['required', 'max:190', Rule::in([0, 1, 2])],
                    'language' => ['required', 'max:190', 'exists:App\Models\Language,id'],
                ], [], [])->validate();
            }
        }


        DB::transaction(function () use ($data) {
            $studRes;
            $mother_id = null;
            $father_id = null;
            if ($data['addMotherType'] == 1) {
                $mother_id = Parents::createAndGetId([
                    'first_name' => $data['mother_firstName'],
                    'last_name' => $data['mother_lastName'],
                    'job' => $data['mother_job'],
                    'phone' => $data['mother_phone'],
                    'gender' => 'female',
                ]);
            } else {
                $mother_id = $data['exest_mother_id'];
            }

            if ($data['addFatherType'] == 1) {
                $father_id = Parents::createAndGetId([
                    'first_name' => $data['father_firstName'],
                    'last_name' => $data['father_lastName'],
                    'job' => $data['father_job'],
                    'phone' => $data['father_phone'],
                    'gender' => 'male',
                ]);
            } else {
                $father_id = $data['exest_father_id'];
            }

            $divisionId = null;
            $divisions = Division::getDivisionStudentsByLevelId($data['level_to_study']);

            foreach ($divisions as $value) {
                if ($value->capacity >= $value->students) {
                    $divisionId = $value->id;
                    break;
                }
                $divisionId = $value->division;
            }

            $studRes = Student::createAndGetId([
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'birth_date' => \Carbon\Carbon::create($data['birth_date']),
                'birth_place' => $data['birth_place'],
                'gender' => $data['gender'],
                'city_id' => $data['city'],
                'street' => $data['street'],
                'area' => $data['area'],
                'phone' => $data['phone'],
                'telephone' => $data['telephone'],
                'emergency_phone' => $data['emergency_phone'],
                'emergency_kinship' => $data['kinship'],
                'religion_id' => $data['religion'],
                'mother_id' => $mother_id,
                'father_id' => $father_id,
                'division_id' => $divisionId,
            ]);

            StudentNationality::create([
                "nationality_id" => $data['nationality'],
                "student_id" => $studRes,
            ]);


            if (isset($data['school_sequence'])) {
                foreach ($data['school_sequence'] as $value) {
                    StudentLevels::create([
                        'school' => $value['school_name'],
                        'status' => $value['status'],
                        'year' => $value['year'],
                        'level_id' => $value['level'],
                        'student_id' => $studRes,
                    ]);
                }
            }
            if (isset($data['health-problems'])) {
                foreach ($data['health-problems'] as $value) {
                    StudentHealthRecords::create([
                        'title' => $value['health_problem'],
                        'description' => $value['description'],
                        'student_id' => $studRes,
                    ]);
                }
            }
            if (isset($data['languages'])) {
                foreach ($data['languages'] as $value) {
                    StudentLanguage::create([
                        'level' => $value['level'],
                        'language_id' => $value['language'],
                        'student_id' => $studRes,
                    ]);
                }
            }
            if ($data['transportation'] == 1) {
                foreach ($data['languages'] as $value) {
                    StudentTransportation::create([
                        'student_id' => $studRes,
                    ]);
                }
            }
        });

        return back()->with('success', trans('general.New student added Successfully'));
    }


    public function showUpdateStudentView($id)
    {
        $roles = Role::all();
        $nationalities = Nationality::all();
        $religions = Religion::all();
        $levels = Level::select('levels.*')->distinct()->join('divisions', 'divisions.level_id', '=', 'levels.id')->get();
        $languages = Language::all();
        $cities = Cities::orderBy('title')->get();
        $student = Student::select(
            'students.id as student_id',
            'students.first_name',
            'students.last_name',
            'students.birth_date',
            'students.birth_place',
            'students.gender',
            'students.city_id',
            'students.street',
            'students.area',
            'students.phone',
            'students.telephone',
            'students.emergency_phone',
            'students.emergency_kinship',
            'students.religion_id',
            'students.mother_id',
            'students.father_id',
            'students.division_id',
            'divisions.level_id',
            'student_transportations.id as transportation',
        )
            ->leftJoin('divisions', 'divisions.id', '=', 'students.division_id')
            ->leftJoin('student_transportations', 'student_transportations.student_id', '=', 'students.id')
            ->where("students.id", $id)->get();

        $mother = Parents::find($student[0]->mother_id);
        $father = Parents::find($student[0]->father_id);
        $schoolSequence = StudentLevels::where('student_id', $student[0]->student_id)->get();
        $studentLanguages = StudentLanguage::where('student_id', $student[0]->student_id)->get();
        $studentHealthRecords = StudentHealthRecords::where('student_id', $student[0]->student_id)->get();
        $studentNationalities = StudentNationality::where('student_id', $id)->get();
        $studentNationalitiesIDs = [];
        foreach ($studentNationalities as $value) {
            $studentNationalitiesIDs[] = $value->nationality_id;
        }
        return view('admin.students.students-edit', [
            'student' => $student[0],
            'mother' => $mother,
            'father' => $father,
            'cities' => $cities,
            'schoolSequence' => $schoolSequence,
            'studentNationalitiesIDs' => $studentNationalitiesIDs,
            'studentLanguages' => $studentLanguages,
            'studentHealthRecords' => $studentHealthRecords,
            'languages' => $languages,
            'nationalities' => $nationalities,
            'religions' => $religions,
            'levels' => $levels,
        ]);
    }


    public function updateStudent(Request $request)
    {
        $data = ($request->all());
        $data['nationality'] = explode(',', $data['nationality']);
        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
            'firstName' => ['required', 'max:190'],
            'lastName' => ['required', 'max:190'],
            'gender' => ['required', 'max:190', Rule::in(['male', 'female'])],
            'nationality' => ['required', 'array'],
            'nationality.*' => ['exists:App\Models\Nationality,id'],
            'birth_place' => ['required', 'max:190'],
            'birth_date' => ['required', 'max:190'],
            'religion' => ['required', 'max:190', 'exists:App\Models\Religion,id'],
            'level_to_study' => ['required', 'max:190', 'exists:App\Models\Level,id'],
            'phone' => ['required', 'max:190'],
            'telephone' => ['required', 'max:190'],
        ], [], []);

        if ($validator->fails()) {
            $response['error'] = $validator->messages();
            return new JsonResponse($response, 400);
        } else {
            $student = Student::find($data['student_id']);
            if ($student) {
                $student->first_name = $data['firstName'];
                $student->last_name = $data['lastName'];
                $student->birth_date = $data['birth_date'];
                $student->birth_place = $data['birth_place'];
                $student->gender = $data['gender'];
                $student->phone = $data['phone'];
                $student->telephone = $data['telephone'];
                $student->religion_id = $data['religion'];

                $studentDivision = Division::find($student->division_id);
                if ($studentDivision->level_id != $data['level_to_study']) {
                    $divisionId = null;
                    $divisions = Division::getDivisionStudentsByLevelId($data['level_to_study']);
                    foreach ($divisions as $value) {
                        if ($value->capacity >= $value->students) {
                            $divisionId = $value->id;
                            break;
                        }
                        $divisionId = $value->division;
                    }
                    $student->division_id = $divisionId;
                }
                $student->save();


                $studentNationalities = StudentNationality::where('student_id', $student->id)->get();
                $studentOldNationalitiesIDs = [];
                foreach ($studentNationalities as $value) {
                    $studentOldNationalitiesIDs[] = $value->nationality_id;
                }
                $studentNationalitiesToDelete = array_diff($studentOldNationalitiesIDs, $data['nationality']);
                $studentNationalitiesToAdd = array_diff($data['nationality'], $studentOldNationalitiesIDs);

                StudentNationality::where('student_id', $student->id)->whereIn('nationality_id', $studentNationalitiesToDelete)->delete();
                foreach ($studentNationalitiesToAdd as $value) {
                    StudentNationality::create([
                        'student_id' => $student->id,
                        'nationality_id' => $value,
                    ]);
                }


                $response = [
                    'data' => '',
                    'message' => trans('general.student_updated_successfully')
                ];
                return new JsonResponse($response, 201);
            }

            $response = [
                'error' => trans('general.record_not_found')
            ];
            return new JsonResponse($response, 400);
        }
    }


    public function updateMother(Request $request)
    {
        $data = ($request->all());
        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
            'editMotherType' => ['required', 'max:190', Rule::in(['0', '1', '2'])],
        ], [], []);

        if ($validator->fails()) {
            $response['error'] = $validator->messages();
            return new JsonResponse($response, 400);
        }

        if ($data['editMotherType'] == 2) {
            $validator = Validator::make($data, [
                'mother_firstName' => ['required', 'max:190'],
                'mother_lastName' => ['required', 'max:190'],
                'mother_job' => ['required', 'max:190'],
                'mother_phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone'],
            ], [], []);

            if ($validator->fails()) {
                $response['error'] = $validator->messages();
                return new JsonResponse($response, 400);
            } else {
                # create new parent account
                $newMother = Parents::createAndGetId([
                    'first_name' => $data['mother_firstName'],
                    'last_name' => $data['mother_lastName'],
                    'job' => $data['mother_job'],
                    'phone' => $data['mother_phone'],
                    'gender' => 'female',
                ]);

                $student = Student::find($data['student_id']);
                $student->mother_id = $newMother;
                $student->save();

                $response = [
                    'data' => '',
                    'message' => trans('general.student_updated_successfully')
                ];
                return new JsonResponse($response, 201);
            }
        } else if ($data['editMotherType'] == 0) {
            $validator = Validator::make($data, [
                'mother_id' => ['required', 'max:190'],
                'mother_firstName' => ['required', 'max:190'],
                'mother_lastName' => ['required', 'max:190'],
                'mother_job' => ['required', 'max:190'],
                'mother_phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone,' . ($data['mother_id'] ?? 0)],
            ], [], []);

            if ($validator->fails()) {
                $response['error'] = $validator->messages();
                return new JsonResponse($response, 400);
            } else {
                # edit current account
                $mother = Parents::find($data['mother_id']);
                $mother->first_name = $data['mother_firstName'];
                $mother->last_name = $data['mother_lastName'];
                $mother->job = $data['mother_job'];
                $mother->phone = $data['mother_phone'];
                $mother->save();

                $response = [
                    'data' => '',
                    'message' => trans('general.student_updated_successfully')
                ];
                return new JsonResponse($response, 201);
            }
        } else if ($data['editMotherType'] == 1) {
            $validator = Validator::make($data, [
                'mother_id' => ['required', 'max:190', 'exists:App\Models\Parents,id'],
            ], [], []);

            if ($validator->fails()) {
                $response['error'] = $validator->messages();
                return new JsonResponse($response, 400);
            } else {
                $student = Student::find($data['student_id']);
                $student->mother_id = $data['mother_id'];
                $student->save();

                $response = [
                    'data' => '',
                    'message' => trans('general.student_updated_successfully')
                ];
                return new JsonResponse($response, 201);
            }
        }

        $response = [
            'error' => trans('general.error')
        ];
        return new JsonResponse($response, 400);
    }


    public function updateFather(Request $request)
    {
        $data = ($request->all());
        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
            'editFatherType' => ['required', 'max:190', Rule::in(['0', '1', '2'])],
        ], [], []);

        if ($validator->fails()) {
            $response['error'] = $validator->messages();
            return new JsonResponse($response, 400);
        }

        if ($data['editFatherType'] == 2) {
            $validator = Validator::make($data, [
                'father_firstName' => ['required', 'max:190'],
                'father_lastName' => ['required', 'max:190'],
                'father_job' => ['required', 'max:190'],
                'father_phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone'],
            ], [], []);

            if ($validator->fails()) {
                $response['error'] = $validator->messages();
                return new JsonResponse($response, 400);
            } else {
                # create new parent account
                $newFather = Parents::createAndGetId([
                    'first_name' => $data['father_firstName'],
                    'last_name' => $data['father_lastName'],
                    'job' => $data['father_job'],
                    'phone' => $data['father_phone'],
                    'gender' => 'male',
                ]);

                $student = Student::find($data['student_id']);
                $student->father_id = $newFather;
                $student->save();

                $response = [
                    'data' => '',
                    'message' => trans('general.student_updated_successfully')
                ];
                return new JsonResponse($response, 201);
            }
        } else if ($data['editFatherType'] == 0) {
            $validator = Validator::make($data, [
                'father_id' => ['required', 'max:190'],
                'father_firstName' => ['required', 'max:190'],
                'father_lastName' => ['required', 'max:190'],
                'father_job' => ['required', 'max:190'],
                'father_phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone,' . ($data['father_id'] ?? 0)],
            ], [], []);

            if ($validator->fails()) {
                $response['error'] = $validator->messages();
                return new JsonResponse($response, 400);
            } else {
                # edit current account
                $father = Parents::find($data['father_id']);
                $father->first_name = $data['father_firstName'];
                $father->last_name = $data['father_lastName'];
                $father->job = $data['father_job'];
                $father->phone = $data['father_phone'];
                $father->save();

                $response = [
                    'data' => '',
                    'message' => trans('general.student_updated_successfully')
                ];
                return new JsonResponse($response, 201);
            }
        } else if ($data['editFatherType'] == 1) {
            $validator = Validator::make($data, [
                'father_id' => ['required', 'max:190', 'exists:App\Models\Parents,id'],
            ], [], []);

            if ($validator->fails()) {
                $response['error'] = $validator->messages();
                return new JsonResponse($response, 400);
            } else {
                $student = Student::find($data['student_id']);
                $student->father_id = $data['father_id'];
                $student->save();

                $response = [
                    'data' => '',
                    'message' => trans('general.student_updated_successfully')
                ];
                return new JsonResponse($response, 201);
            }
        }

        $response = [
            'error' => trans('general.error')
        ];
        return new JsonResponse($response, 400);
    }

    public function updateAddress_Transportation_Emergency(Request $request)
    {
        $data = ($request->all());

        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
            'transportation' => ['required', 'max:190'],
            'city' => ['required', 'max:190', 'exists:App\Models\Cities,id'],
            'area' => ['required', 'max:190'],
            'street' => ['required', 'max:2550'],
            'emergency_phone' => ['required', 'max:190'],
            'kinship' => ['required', 'max:190'],
        ], [], []);

        if ($validator->fails()) {
            $response['error'] = $validator->messages();
            return new JsonResponse($response, 400);
        }

        $student = Student::find($data['student_id']);
        $student->city_id = $data['city'];
        $student->area = $data['area'];
        $student->street = $data['street'];
        $student->emergency_phone = $data['emergency_phone'];
        $student->emergency_kinship = $data['kinship'];
        $student->save();

        $studentTransportation = StudentTransportation::where('student_id', $data['student_id'])->get();

        if ($data['transportation'] == 1 && count($studentTransportation) <= 1) {
            StudentTransportation::create([
                'student_id' => $data['student_id'],
            ]);
        } elseif ($data['transportation'] == 0 && count($studentTransportation) >= 1) {
            StudentTransportation::where('student_id', $data['student_id'])->delete();
        }

        $response = [
            'data' => '',
            'message' => trans('general.student_updated_successfully')
        ];
        return new JsonResponse($response, 201);
    }


    public function updateSequence(Request $request)
    {

        $data = ($request->all());
        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
            'school_sequence' => ['required', 'array'],
            'school_sequence.*.sequence_id' => ['max:190'],
            'school_sequence.*.level' => ['required', 'max:190', 'exists:App\Models\Level,id'],
            'school_sequence.*.school_name' => ['required', 'max:190'],
            'school_sequence.*.year' => ['required', 'max:190'],
            'school_sequence.*.status' => ['required', 'max:190', Rule::in(['0', '1'])],
        ], [], []);

        if ($validator->fails()) {
            $response['error'] = $validator->messages();
            return new JsonResponse($response, 400);
        }
        $studentLevels = StudentLevels::where('student_id', $data['student_id'])->get();
        $currentStudentsLevels = [];

        foreach ($studentLevels as $value) {
            $currentStudentsLevels[] = $value->id;
        }


        $newStudentsLevels = [];

        foreach ($data['school_sequence'] as $value) {
            $newStudentsLevels[] = $value['sequence_id'];
        }

        $levelsToAdd = array_diff($newStudentsLevels, $currentStudentsLevels);
        $levelsToDelete = array_diff($currentStudentsLevels, $newStudentsLevels);
        $levelsToEdit = array_diff($newStudentsLevels, array_merge($levelsToAdd, $levelsToDelete));

        foreach ($data['school_sequence'] as $value) {
            if ($value['sequence_id'] == null) {
                StudentLevels::create([
                    'student_id' => $data['student_id'],
                    'school' => $value['school_name'],
                    'status' => $value['status'],
                    'year' => $value['year'],
                    'level_id' => $value['level'],
                ]);
            } else {
                $stLevel = StudentLevels::find($value['sequence_id']);
                if ($stLevel) {
                    $stLevel->school = $value['school_name'];
                    $stLevel->status = $value['status'];
                    $stLevel->year = $value['year'];
                    $stLevel->level_id = $value['level'];
                    $stLevel->save();
                }
            }
        }

        StudentLevels::whereIn('id', $levelsToDelete)->delete();

        $response = [
            'data' => '',
            'message' => trans('general.student_updated_successfully')
        ];
        return new JsonResponse($response, 201);
    }


    public function updateLanguages(Request $request)
    {
        $data = ($request->all());
        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
            'languages' => ['required', 'array'],
            'languages.*.language' => ['required', 'max:190', 'exists:App\Models\Language,id'],
            'languages.*.level' => ['required', 'max:190'],
            'languages.*.student_lang_id' => ['max:190'],
        ], [], []);

        if ($validator->fails()) {
            $response['error'] = $validator->messages();
            return new JsonResponse($response, 400);
        }
        // dd($request->all());

        $studentLanguage = StudentLanguage::where('student_id', $data['student_id'])->get();
        $currentStudentsLanguage = [];

        foreach ($studentLanguage as $value) {
            $currentStudentsLanguage[] = $value->id;
        }

        $newStudentsLanguage = [];

        foreach ($data['languages'] as $value) {
            $newStudentsLanguage[] = $value['student_lang_id'];
        }

        // $languageToAdd = array_diff($newStudentsLanguage, $currentStudentsLanguage);
        $languageToDelete = array_diff($currentStudentsLanguage, $newStudentsLanguage);
        // $languageToEdit = array_diff($newStudentsLanguage, array_merge($languageToAdd, $languageToDelete));


        foreach ($data['languages'] as $value) {
            print_r($value['student_lang_id']);
            if ($value['student_lang_id'] == null) {
                StudentLanguage::create([
                    'level' => $value['level'],
                    'language_id' => $value['language'],
                    'student_id' => $data['student_id'],
                ]);
            } else {
                $stLang = StudentLanguage::find($value['student_lang_id']);
                if ($stLang) {
                    $stLang->level = $value['level'];
                    $stLang->language_id = $value['language'];
                    $stLang->save();
                }
            }
        }

        StudentLanguage::whereIn('id', $languageToDelete)->delete();

        $response = [
            'data' => '',
            'message' => trans('general.student_updated_successfully')
        ];
        return new JsonResponse($response, 201);
    }


    public function updateHealth(Request $request)
    {

        $data = ($request->all());
        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
            'health-problems' => ['required', 'array'],
            'health-problems.*.health_problem' => ['required', 'max:190'],
            'health-problems.*.description' => ['required', 'max:190'],
            'health-problems.*.student_health_id' => ['max:190'],
        ], [], []);

        if ($validator->fails()) {
            $response['error'] = $validator->messages();
            return new JsonResponse($response, 400);
        }


        $studentHealthRecords = StudentHealthRecords::where('student_id', $data['student_id'])->get();
        $currentStudentsHealthRecords = [];

        foreach ($studentHealthRecords as $value) {
            $currentStudentsHealthRecords[] = $value->id;
        }

        $newStudentsHealthRecords = [];

        foreach ($data['health-problems'] as $value) {
            $newStudentsHealthRecords[] = $value['student_health_id'];
        }


        // $healthRecordsToAdd = array_diff($newStudentsHealthRecords, $currentStudentsHealthRecords);
        $healthRecordsToDelete = array_diff($currentStudentsHealthRecords, $newStudentsHealthRecords);
        // $healthRecordsToEdit = array_diff($newStudentshealthRecords, array_merge($healthRecordsToAdd, $healthRecordsToDelete));


        foreach ($data['health-problems'] as $value) {
            if ($value['student_health_id'] == null) {
                StudentHealthRecords::create([
                    'title' => $value['health_problem'],
                    'description' => $value['description'],
                    'student_id' => $data['student_id'],
                ]);
            } else {
                $stLang = StudentHealthRecords::find($value['student_health_id']);
                if ($stLang) {
                    $stLang->title = $value['health_problem'];
                    $stLang->description = $value['description'];
                    $stLang->save();
                }
            }
        }

        StudentHealthRecords::whereIn('id', $healthRecordsToDelete)->delete();

        $response = [
            'data' => '',
            'message' => trans('general.student_updated_successfully')
        ];
        return new JsonResponse($response, 201);
    }

    public function delete(Request $request)
    {
        $data = ($request->all());
        $validator = Validator::make($data, [
            'student_id' => ['required', 'max:190', 'exists:App\Models\Student,id'],
        ], [], [])->validate();

        Student::where('id', $data['student_id'])->delete();

        return back()->with('success', trans('general.student_was_deleted'));
    }
}
