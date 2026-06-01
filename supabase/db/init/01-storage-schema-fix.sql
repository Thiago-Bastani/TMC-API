-- Supabase Storage API v1.11+ requires a `hash` column in storage.migrations.
-- The supabase/postgres image pre-creates the storage schema without it.
-- This script adds the column when it's missing so the storage-api can start cleanly.

DO $$
BEGIN
  IF EXISTS (
    SELECT 1 FROM information_schema.tables
    WHERE table_schema = 'storage' AND table_name = 'migrations'
  ) THEN
    IF NOT EXISTS (
      SELECT 1 FROM information_schema.columns
      WHERE table_schema = 'storage' AND table_name = 'migrations' AND column_name = 'hash'
    ) THEN
      ALTER TABLE storage.migrations ADD COLUMN hash TEXT;
    END IF;
  END IF;
END
$$;
