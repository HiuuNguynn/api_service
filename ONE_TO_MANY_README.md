# Mối quan hệ 1-N (One-to-Many) trong Laravel

Dự án này đã được cấu hình để xử lý mối quan hệ 1-n giữa Person và Subject.

## 📋 **Mô tả mối quan hệ**

- **Person (1)** → **Subject (N)**: Một người có thể có nhiều môn học
- **Subject (N)** → **Person (1)**: Một môn học thuộc về một người

## 🗄️ **Cấu trúc Database**

### Bảng `people`
```sql
- id (primary key)
- name
- email
- phone
- address
- created_at
- updated_at
```

### Bảng `subjects`
```sql
- id (primary key)
- name
- description
- person_id (foreign key → people.id)
- created_at
- updated_at
```

## 🔗 **Eloquent Relationships**

### Model Person
```php
class Person extends Model
{
    // Một Person có nhiều Subject
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    // Accessor để đếm số subjects
    public function getSubjectsCountAttribute()
    {
        return $this->subjects()->count();
    }
}
```

### Model Subject
```php
class Subject extends Model
{
    // Một Subject thuộc về một Person
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
```

## 🚀 **Cách sử dụng**

### 1. **Lấy tất cả subjects của một person**
```php
$person = Person::find(1);
$subjects = $person->subjects; // Collection của subjects

// Hoặc với eager loading
$person = Person::with('subjects')->find(1);
```

### 2. **Lấy person của một subject**
```php
$subject = Subject::find(1);
$person = $subject->person; // Person object
```

### 3. **Tạo subject cho một person**
```php
// Cách 1: Sử dụng relationship
$person = Person::find(1);
$person->subjects()->create([
    'name' => 'Mathematics',
    'description' => 'Advanced mathematics course'
]);

// Cách 2: Tạo trực tiếp
Subject::create([
    'name' => 'Physics',
    'description' => 'Physics course',
    'person_id' => 1
]);
```

### 4. **Lấy person với số lượng subjects**
```php
$people = Person::withCount('subjects')->get();
foreach ($people as $person) {
    echo $person->name . ' has ' . $person->subjects_count . ' subjects';
}
```

### 5. **Lọc subjects theo person**
```php
$subjects = Subject::where('person_id', 1)->get();
// Hoặc
$subjects = Subject::whereHas('person', function($query) {
    $query->where('name', 'John Doe');
})->get();
```

## 🎯 **Tính năng đã implement**

### **PersonController**
- `index()`: Hiển thị danh sách people với số lượng subjects
- `show($id)`: Hiển thị chi tiết person với tất cả subjects

### **SubjectController**
- `create()`: Form tạo subject với dropdown chọn person
- `store()`: Lưu subject và redirect về trang person
- `edit()`: Form edit subject
- `update()`: Cập nhật subject
- `destroy()`: Xóa subject và redirect về trang person

### **Views**
- **`people/index.blade.php`**: Hiển thị danh sách với số lượng subjects
- **`people/show.blade.php`**: Chi tiết person với grid subjects
- **`subject/create.blade.php`**: Form tạo subject với person selection

## 📊 **Ví dụ sử dụng trong code**

### **Tạo dữ liệu mẫu**
```php
// Tạo person
$person = Person::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'phone' => '123456789',
    'address' => '123 Main St'
]);

// Tạo subjects cho person
$person->subjects()->createMany([
    [
        'name' => 'Mathematics',
        'description' => 'Advanced mathematics course'
    ],
    [
        'name' => 'Physics',
        'description' => 'Physics fundamentals'
    ],
    [
        'name' => 'Chemistry',
        'description' => 'Organic chemistry'
    ]
]);
```

### **Query với conditions**
```php
// Lấy people có ít nhất 2 subjects
$people = Person::has('subjects', '>=', 2)->get();

// Lấy subjects của people có email chứa 'gmail'
$subjects = Subject::whereHas('person', function($query) {
    $query->where('email', 'like', '%gmail%');
})->get();

// Lấy person với subjects được sắp xếp theo tên
$person = Person::with(['subjects' => function($query) {
    $query->orderBy('name');
}])->find(1);
```

### **Aggregate functions**
```php
// Đếm tổng số subjects của tất cả people
$totalSubjects = Person::withCount('subjects')->get()->sum('subjects_count');

// Lấy person có nhiều subjects nhất
$personWithMostSubjects = Person::withCount('subjects')
    ->orderBy('subjects_count', 'desc')
    ->first();
```

## 🔧 **Migration**

Migration đã được tạo để thêm foreign key:
```php
Schema::table('subjects', function (Blueprint $table) {
    $table->foreignId('person_id')->nullable()->constrained('people')->onDelete('cascade');
});
```

## ⚠️ **Lưu ý quan trọng**

1. **Cascade Delete**: Khi xóa person, tất cả subjects sẽ bị xóa theo
2. **Nullable**: Foreign key có thể null (subject có thể không thuộc về person nào)
3. **Validation**: Tất cả forms đều có validation cho person_id
4. **Eager Loading**: Sử dụng `with()` để tránh N+1 query problem

## 🎨 **UI Features**

- **Badge hiển thị số subjects** trong danh sách people
- **Grid layout** cho subjects trong trang chi tiết
- **Empty state** khi person chưa có subjects
- **Quick actions** để thêm/edit/delete subjects
- **Responsive design** với Tailwind CSS 