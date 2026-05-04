Schema::create('project', function (Blueprint $table) { 
$table->id();
$table->string('title');
$table->text('description')->nullable(); 
$table->date('deadline')->nullable(); 
$table->softDeletes(); // → crée la colonne deleted_at $table->timestamps(); });


Schema::create('member', function (Blueprint $table) {
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->enum('role', ['lead', 'developer']);
    $table->timestamps();
    $table->primary(['project_id', 'user_id']);
});


Schema::create('task', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
    $table->string('title');
    $table->text('description')->nullable();
    $table->date('deadline')->nullable();
    $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
    $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
    $table->timestamps();
});
